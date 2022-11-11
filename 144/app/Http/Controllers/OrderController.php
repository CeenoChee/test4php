<?php

namespace App\Http\Controllers;

use App\Libs\Enums\Payment;
use App\Libs\Enums\Shipping;
use App\Libs\Fct;
use App\Libs\LUrl;
use App\Libs\ShipmentCost;
use App\Libs\SimplePay\SimplePayIpn;
use App\Libs\Transaction;
use App\Mail\OrderCheckout;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Order;
use App\Models\Transaction as TransactionModel;
use App\Repositories\CountryRepository;
use App\Repositories\ShippingAddressRepository;
use App\Services\AddressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected AddressService $addressService;
    protected ShippingAddressRepository $shippingAddressRepo;

    public function __construct(AddressService $addressService, ShippingAddressRepository $shippingAddressRepo)
    {
        $this->addressService = $addressService;
        $this->shippingAddressRepo = $shippingAddressRepo;
    }

    public function prices(Request $request): array
    {
        $country = Country::findOrFail($request->Orszag_ID);

        $itemAmount = app('Cart')->getItemAmount();

        $shipmentCost = new ShipmentCost();
        $shipmentCost->setCountry($country);
        $shipmentCost->setPrice($itemAmount);
        $shipmentCost->setShipping(new Shipping($request->Szallitas));

        $shippingPrice = $shipmentCost->getCost();

        return [
            'shipping_price_text' => Fct::price($shippingPrice),
            'sum_price_text' => Fct::price($itemAmount->add($shippingPrice)),
        ];
    }

    public function checkout()
    {
        if ($redirect = $this->pageValidate('checkout')) {
            return $redirect;
        }

        $cart = app('Cart');

        $productSourceHandler = app('ProductSourceHandler');
        $productSourceHandler->setWarehouse($cart->getWarehouse());

        foreach ($cart->getCartItems() as $cartItem) {
            $productSourceHandler->addProduct($cartItem->Termek_ID);
        }

        return view('pages.orders.checkout', [
            'order' => new \App\Libs\Order($cart->getCart()),
            'errorMessages' => $cart->validate(),
        ]);
    }

    public function checkoutSave(Request $request): ?RedirectResponse
    {
        if ($redirect = $this->pageValidate('checkout')) {
            return $redirect;
        }

        $cart = app('Cart');

        if (! $cart->isValidPayment()) {
            abort(500);
        }

        $cartRow = $cart->getCart();
        $cartRow->Megjegyzes = $request->megjegyzes;

        if (is_numeric($cartRow->Orszag)) {
            $cartRow->Orszag = (new CountryRepository())->getCodeById($cartRow->Orszag);
        }

        $cartRow->save();

        $user = app('User');

        if ($cartRow->getPayment()->is(Payment::CREDIT_CARD)) {
            $transaction = new Transaction($user->getCustomerEmployee(), $cartRow->getTotal(), LUrl::route('order.simple.pay.back', ['locale' => app('Lang')->getLocale()]));
            $transaction->setContact('cart', $cartRow->Kosar_ID);
            $transaction->setDeliveryAddress($cartRow->getDeliveryAddress());

            $transaction = $transaction->start();

            if ($transaction instanceof RedirectResponse) {
                return $transaction;
            }

            return redirect()->to($transaction);
        }

        $order = $cart->order();

        if (! $order) {
            return redirect()->route(LUrl::name('checkout'));
        }

        $successMessage = trans('pages/orders.thank_you');

        try {
            Mail::send(new OrderCheckout($user->getEmail(), $user->getName(), $order));
            Mail::send(new OrderCheckout(config('riel.emails.order.email'), config('riel.emails.order.name'), $order));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $successMessage = trans('pages/orders.order_thank_you_with_error');
        }

        flash()->success($successMessage);

        return redirect()
            ->route(LUrl::name('order.thank.you'), [
                'Ev' => $order->getYear(),
                'Sorozat' => $order->getSerial(),
                'Sorszam' => str_pad($order->getSerialNumber(), 6, '0', STR_PAD_LEFT),
            ])->with(['thank_you' => true]);
    }

    public function simplePayBack(Request $request): RedirectResponse
    {
        $transaction = Transaction::back($request);

        $message = '';
        $success = false;

        if ($transaction && $transaction->Tipus == 'cart') {
            switch ($transaction->Event) {
                case 'TIMEOUT':
                    $message = trans('pages/orders.unsuccessful_payment_timeout', ['simple_pay' => $transaction->TransactionID]);

                    break;

                case 'CANCEL':
                    $message = trans('pages/orders.unsuccessful_payment_canceled', ['simple_pay' => $transaction->TransactionID]);

                    break;

                case 'FAIL':
                    $message = trans('pages/orders.unsuccessful_payment_fail', ['simple_pay' => $transaction->TransactionID]);

                    break;

                case 'SUCCESS':
                    $message = trans('pages/orders.successful_transaction', ['simple_pay' => $transaction->TransactionID]);
                    $success = true;

                    break;
            }
        } else {
            abort(500);
        }

        if (! $success) {
            flash()->error($message);

            return redirect()->route(LUrl::name('checkout'));
        }

        // Kosár kikeresése a tranzakció alapján.
        $cart = Cart::where('Kosar_ID', $transaction->Adat)->first();

        if (! $cart) {
            abort(500);
        }

        // Kosár lezárása
        $order = $cart->order();

        if (! $order) {
            return redirect()->route(LUrl::name('home'));
        }

        // Minden hozzá tartozó tranzakció lekérdezése
        $relatedTransactions = TransactionModel::where('Tipus', 'cart')->where('Adat', $transaction->Adat)->get();

        $orderNumber = $order->getNumber();
        foreach ($relatedTransactions as $relatedTransaction) {
            $relatedTransaction->Tipus = 'order';
            $relatedTransaction->Adat = $orderNumber;
            $relatedTransaction->save();
        }

        Mail::send(new OrderCheckout($order->getEmail(), $order->getName(), $order));
        Mail::send(new OrderCheckout(config('riel.emails.order.email'), config('riel.emails.order.name'), $order));

        flash()->success($message);

        return redirect()
            ->route(LUrl::name('order.thank.you'), [
                'Ev' => $order->getYear(),
                'Sorozat' => $order->getSerial(),
                'Sorszam' => str_pad($order->getSerialNumber(), 6, '0', STR_PAD_LEFT),
            ])->with(['thank_you' => true]);
    }

    public function simplePayIpn(Request $request)
    {
        $json = file_get_contents('php://input');

        $trx = new SimplePayIpn();
        $trx->addData('currency', Str::upper($request->currency_code));

        $trx->addConfig(config('riel.simplepay'));

        if ($trx->isIpnSignatureCheck($json)) {
            $trx->runIpnConfirm();
        }
    }

    public function myOrders()
    {
        $customer = app('User')->getCustomer();

        $orders = [];

        $synchronizedOrders = Order::whereCustomer($customer)->orderBy('ModDatum', 'desc')->with('items')->paginate(20);

        if ($synchronizedOrders->currentPage() == 1) {
            $carts = Cart::closed()->whereCustomer($customer)->orderBy('updated_at', 'desc')->with('items')->get();
            foreach ($carts as $cart) {
                $orders[] = new \App\Libs\Order($cart);
            }
        }

        foreach ($synchronizedOrders as $order) {
            $orders[] = new \App\Libs\Order($order);
        }

        return view('pages.orders.index', [
            'orders' => $orders,
            'synchronizedOrders' => $synchronizedOrders,
        ]);
    }

    public function show(Request $request)
    {
        $order = \App\Libs\Order::findOrFail($request->Ev, $request->Sorozat, $request->Sorszam);

        $customer = app('User')->getCustomer();
        $customerEmployee = $order->getCustomerEmployee();

        if ($customer->Ugyfel_ID != $customerEmployee->Ugyfel_ID) {
            abort(403);
        }

        return view('pages.orders.show', [
            'order' => $order,
        ]);
    }

    public function thankYou(Request $request)
    {
        $order = \App\Libs\Order::find($request->Ev, $request->Sorozat, $request->Sorszam);

        if (! $order) {
            abort(404);
        }

        $thankYou = session('thank_you');

        if (! $thankYou) {
            return redirect()
                ->route(LUrl::name('account.order.show'), [
                    'Ev' => $order->getYear(),
                    'Sorozat' => $order->getSerial(),
                    'Sorszam' => str_pad($order->getSerialNumber(), 6, '0', STR_PAD_LEFT),
                ]);
        }

        $simplePay = session('simple_pay');

        $customer = app('User')->getCustomer();
        $customerEmployee = $order->getCustomerEmployee();

        if ($customer->Ugyfel_ID != $customerEmployee->Ugyfel_ID) {
            abort(403);
        }

        return view('pages.orders.thank-you', [
            'order' => $order,
            'simplePay' => $simplePay,
        ]);
    }

    protected function pageValidate($page): ?RedirectResponse
    {
        $cart = app('Cart');
        $cart->updateShipmentCost();

        switch ($page) {
            case 'checkout':
                if (! $cart->isValidPayment()) {
                    return redirect()
                        ->route(LUrl::name('billing'));
                }

                break;
        }

        return null;
    }
}
