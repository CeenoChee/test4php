<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillingRequest;
use App\Libs\LUrl;
use App\Repositories\CountryRepository;
use App\Services\AddressService;
use Illuminate\Http\RedirectResponse;

class BillingController extends Controller
{
    protected AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index()
    {
        $cart = app('Cart')->getCart();

        $customer = app('User')->getCustomer();

        $this->addressService->refreshShippingAddresses($customer);

        $this->addressService->addPremisesToCustomerForBilling($customer, $cart);

        // Ha nincs beállítva a fuvar akkor vissza a rendelés módjának kiválasztására
        if ($cart->getShipmentCost()->is(null)) {
            return redirect()
                ->route(LUrl::name('shipping'));
        }

        $user = app('User');

        return view('pages.orders.billing', [
            'cart' => $cart,
            'isForeigner' => app('User')->isForeigner(),
            'canTransfer' => $user->canTransfer(),
            'canUseCreditCard' => $user->canUseCreditCard(),
            'payment' => $cart->getPayment(),
            'customer' => $customer,
            'countries' => (new CountryRepository())->all()->pluck('Nev', 'Orszag_ID'),
        ]);
    }

    public function store(BillingRequest $request): ?RedirectResponse
    {
        $cart = app('Cart')->getCart();
        $cart->FizetesiMod_ID = (int) $request->payment;
        $cart->UgyfelCim_ID = $request->UgyfelCim_ID;
        $cart->UgyfelTelephely_ID = $request->address == 1 ? null : $request->address;
        $cart->save();

        return redirect()->route(LUrl::name('shipping'));
    }
}
