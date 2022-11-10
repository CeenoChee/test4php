<?php

namespace App\Libs\Cart;

use App\Libs\Enums\Payment;
use App\Libs\Enums\ReceptionType;
use App\Libs\Enums\ShipmentCost as ShipmentCostEnum;
use App\Libs\Enums\Shipping;
use App\Libs\Price;
use App\Libs\ShipmentCost;
use App\Models\Cart as CartModel;
use App\Models\CartItem;
use App\Models\PickupLocation;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\DB;

class Cart
{
    private $customerEmployee;
    private $cart;

    private $count;
    private $items;
    private $isValidShipping;
    private $isValidPayment;

    private $qty;

    private $allOrderedQty;

    public function __construct()
    {
        $this->customerEmployee = app('User')->getCustomerEmployee();
        if ($this->customerEmployee) {
            $this->cart = CartModel::whereCustomerEmployee($this->customerEmployee)->opened()->first();
            if (! $this->cart) {
                $this->createCart();
            }
        }
    }

    public function order()
    {
        return $this->cart->order();
    }

    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Kosárba helyezett tételek száma.
     */
    public function getCount()
    {
        if ($this->count === null) {
            if ($this->customerEmployee) {
                $this->count = (int) CartItem::where('Kosar_ID', $this->cart->Kosar_ID)->count();
            } else {
                $this->count = 0;
            }
        }

        return $this->count;
    }

    public function inCart(Product $product)
    {
        return $this->getQty($product) > 0;
    }

    public function getQty(Product $product)
    {
        if ($this->qty === null) {
            $this->qty = CartItem::where('Kosar_ID', $this->cart->Kosar_ID)->pluck('Mennyiseg', 'Termek_ID')->toArray();
        }
        if (array_key_exists($product->Termek_ID, $this->qty)) {
            return $this->qty[$product->Termek_ID];
        }

        return 0;
    }

    /**
     * Igazat ad vissza ha üres a kosár.
     */
    public function isEmpty(): bool
    {
        return $this->getCount() == 0;
    }

    /**
     * Igazat ad vissza ha a szállítás rendesen ki van töltve.
     */
    public function isValidShipping(): bool
    {
        if ($this->isValidShipping !== null) {
            return $this->isValidShipping;
        }

        if ($this->isEmpty()) {
            $this->isValidShipping = false;

            return false;
        }

        // Átvétel
        $receptionType = $this->cart->getReceptionType();

        if ($receptionType->is(null)) {
            $this->isValidShipping = false;

            return false;
        }

        // Szállítás ki van töltve
        if ($this->cart->Szallitas === null || ! in_array(
            $this->cart->Szallitas,
            [
                Shipping::WHOLE,
                Shipping::ITEM_PART,
            ]
        )
        ) {
            $this->isValidShipping = false;

            return false;
        }

        // Visszárú ki van tölteve
        if ($this->cart->Visszaru === null) {
            $this->isValidShipping = false;

            return false;
        }

        // Személyes átvevőhely vagy szállítási cím ellenőrzése
        if ($this->cart->getShipmentCost()->is(ShipmentCostEnum::CUSTOMER)) {
            $this->isValidShipping = (PickupLocation::where('SzemAtvevohely_ID', $this->cart->SzemAtvevohely_ID)->count() == 1);
        } else {
            if ($this->cart->Nev) {
                $this->isValidShipping = (ShippingAddress::where([
                    ['Ugyfel_ID', $this->cart->Ugyfel_ID],
                    ['Nev', $this->cart->Nev],
                ])->count() > 0);
            } else {
                $this->isValidShipping = true;
            }
        }

        return $this->isValidShipping;
    }

    /**
     * Igazat ad vissza ha a fizetési mód rendesen ki van töltve.
     */
    public function isValidPayment(): bool
    {
        if ($this->isValidPayment !== null) {
            return $this->isValidPayment;
        }

        if (! $this->isValidShipping() || $this->cart->FizetesiMod_ID === null) {
            $this->isValidPayment = false;

            return false;
        }

        $payments = [
            Payment::PREPAYMENT,
            Payment::TRANSFER,
            Payment::CREDIT_CARD,
        ];

        if ($this->cart->getShipmentCost()->is(ShipmentCostEnum::CUSTOMER)) {
            $payments[] = Payment::CASH;
        }

        if ($this->cart->getShipmentCost()->is(ShipmentCostEnum::SUPPLIER_FREE)) {
            $payments[] = Payment::CASH_ON_DELIVERY;
        }

        $this->isValidPayment = in_array($this->cart->FizetesiMod_ID, $payments);

        return $this->isValidPayment;
    }

    public function getCartItems()
    {
        if ($this->items === null) {
            $this->items = [];
            foreach (
                CartItem::where('Kosar_ID', $this->cart->Kosar_ID)->with('product')->orderBy('updated_at')->get() as $cartItem
            ) {
                $this->items[$cartItem->Termek_ID] = $cartItem;
            }
        }

        return $this->items;
    }

    public function getCartItem(Product $product)
    {
        if (! $this->cart) {
            return null;
        }

        $cartItems = $this->getCartItems();

        return array_key_exists($product->Termek_ID, $cartItems) ? $cartItems[$product->Termek_ID] : null;
    }

    /**
     * Kosár tétel törlése.
     */
    public function deleteCartItem(Product $product)
    {
        $cartItem = $this->getCartItem($product);
        if ($cartItem) {
            $cartItem->delete();

            return $cartItem;
        }

        return null;
    }

    public function getWarehouse()
    {
        return $this->cart->getWarehouse();
    }

    /**
     * Kosár tétel mentése.
     *
     * @param mixed $qty
     */
    public function setProductQty(Product $product, $qty)
    {
        $qty = (int) $qty;
        if ($qty == 0) {
            return $this->deleteCartItem($product);
        }

        $productData = $this->getProductData($product, $qty);

        $cartItem = $this->getCartItem($product);

        if ($cartItem) {
            $cartItem->Mennyiseg = $qty;
            $cartItem->Kod = $productData->Kod;
            $cartItem->Nev = $productData->Nev;
            $cartItem->ListaAr = $this->total($productData->ListaAr);
            $cartItem->AkciosAr = $this->total($productData->AkciosAr);
            $cartItem->UgyfelAr = $this->total($productData->UgyfelAr);
            $cartItem->SzallHatarido = $productData->SzallHatarido;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create(
                [
                    'Kosar_ID' => $this->cart->Kosar_ID,
                    'Termek_ID' => $product->Termek_ID,
                    'Mennyiseg' => $qty,
                    'Kod' => $productData->Kod,
                    'Nev' => $productData->Nev,
                    'ListaAr' => $this->total($productData->ListaAr),
                    'AkciosAr' => $this->total($productData->AkciosAr),
                    'UgyfelAr' => $this->total($productData->UgyfelAr),
                    'SzallHatarido' => $productData->SzallHatarido,
                ]
            );
        }

        $this->updateShipmentCost();

        return $cartItem;
    }

    public function updateShipmentCost(): Cart
    {
        if ($this->cart->getReceptionType()->is(ReceptionType::PERSONAL)) {
            $this->cart->Fuvar = ShipmentCostEnum::CUSTOMER;
            $this->cart->FuvarOsszeg = 0;
        } else {
            $shipmentCost = new ShipmentCost();
            $shipmentCost->setPrice($this->getItemAmount());
            $shipmentCost->setShipping($this->getShipping());
            $shipmentCost->setCountry($this->getDeliveryAddress()->getCountry());
            $shipmentTotalCost = $shipmentCost->getCost()->exchange($this->cart->Deviza_ID)->getTotal();

            $this->cart->Fuvar = ($shipmentTotalCost > 0 ? ShipmentCostEnum::SUPPLIER_FIX : ShipmentCostEnum::SUPPLIER_FREE);
            $this->cart->FuvarOsszeg = $shipmentTotalCost;
        }

        $this->cart->save();

        return $this;
    }

    /**
     * Termék hozzáadása a kosához.
     *
     * @param $qty
     *
     * @return $this
     */
    public function addProductQty(Product $product, $qty)
    {
        $cartItem = $this->getCartItem($product);
        if ($cartItem) {
            $cartItem = $this->setProductQty($product, $cartItem->Mennyiseg + $qty);
        } else {
            $cartItem = $this->setProductQty($product, $qty);
        }

        return $cartItem;
    }

    /**
     * Kosár tétel vizsgálata.
     */
    public function validateCartItem(CartMessages $cartMessages, CartItem $cartItem): bool
    {
        $product = $cartItem->product;

        if (! $product || ! $product->Aktiv || ! $product->Lathato || ($product->getStockLimit() !== null and $product->getStockLimit() < $cartItem->Mennyiseg)) {
            $cartMessages->addHeadMessage(trans('pages/orders.cart_error_not_available', ['code' => $cartItem->Kod]));
            $cartItem->delete();

            return false;
        }

        $productData = $this->getProductData($product, $cartItem->Mennyiseg);

        if ($productData->ListaAr === null) {
            $cartMessages->addHeadMessage(trans('pages/orders.cart_error_not_available', ['code' => $cartItem->Kod]));
            $cartItem->delete();

            return false;
        }

        $currencyID = $cartItem->cart->Kosar_ID;

        $save = false;
        foreach ($productData as $name => $value) {
            if ($value instanceof Price) {
                if ($value->getTotal() != $cartItem->{$name}) {
                    // Ha deviza változás miatt volt az eltérés akkor a hibaüzenetet nem írjuk fel tételenként.
                    if ($value->getCurrency() == $currencyID) {
                        $cartMessages->addItemMessage($cartItem->Termek_ID, trans('pages/orders.cart_error_' . $name));
                    }
                    $cartItem->{$name} = $value->getTotal();
                    $save = true;
                }
            } else {
                if ($value != $cartItem->{$name}) {
                    $messages[] = trans('pages/orders.cart_error_' . $name);
                    $cartItem->{$name} = $value;
                    $save = true;
                }
            }
        }

        if ($save) {
            $cartItem->save();
        }

        return true;
    }

    public function validate()
    {
        $messages = new CartMessages();

        foreach ($this->getCartItems() as $cartItem) {
            $this->validateCartItem($messages, $cartItem);
        }

        $save = false;

        $currencyID = app('User')->getCurrencyID();

        if ((int) $this->cart->Deviza_ID !== $currencyID) {
            $messages->addHeadMessage(trans('pages/orders.cart_error_currency'));
            $this->cart->Deviza_ID = $currencyID;
            $save = true;
        }

        if ($save) {
            $this->cart->save();
        }

        return $messages;
    }

    /**
     * Visszaadja hogy a megadott termékből mennyi van lezárt kosarakban. Ezekbő a szinkron még nem csinált valós
     * rendelést de a megrendelhető mennyiséget csökkentik.
     *
     * @return int|mixed
     */
    public function getAllOrderedQty(Product $product)
    {
        if ($this->allOrderedQty === null) {
            $sql = '
				SELECT kt.Termek_ID, SUM(kt.Mennyiseg) AS Mennyiseg FROM kosar k
				INNER JOIN kosar_tetel kt ON kt.Kosar_ID = k.Kosar_ID
				WHERE k.Ev IS NOT NULL AND k.Sorszam IS NOT NULL
				GROUP BY kt.Termek_ID
			';
            $this->allOrderedQty = [];
            foreach (DB::connection('mysql')->select($sql) as $row) {
                $this->allOrderedQty[$row->Termek_ID] = $row->Mennyiseg;
            }
        }

        return isset($this->allOrderedQty[$product->Termek_ID]) ? $this->allOrderedQty[$product->Termek_ID] : 0;
    }

    /**
     * Kosár tétel javítása.
     */
    public function prepareCartItem(CartItem $cartItem): bool
    {
        $product = $cartItem->product;
        if (! $product || ! $product->Aktiv || ! $product->Lathato) {
            $cartItem->delete();

            return false;
        }

        $productData = $this->getProductData($product, $cartItem->Mennyiseg);
        foreach ($productData as $name => $value) {
            if ($value instanceof Price) {
                $cartItem->{$name} = $value->exchange($this->cart->Deviza_ID);
            } else {
                $cartItem->{$name} = $value;
            }
        }
        $cartItem->save();

        return true;
    }

    public function renderLittleCart()
    {
        return view('pages.cart.includes.little-cart', ['content' => $this->renderLittleCartContent()])->render();
    }

    public function renderLittleCartContent()
    {
        return view('pages.cart.includes.little-cart-content')->render();
    }

    public function getItemAmount()
    {
        return $this->cart->getItemAmount();
    }

    public function getShipmentAmount()
    {
        return $this->cart->getShipmentAmount();
    }

    public function getTotal()
    {
        return $this->cart->getTotal();
    }

    public function getShipmentCost()
    {
        return $this->cart->getShipmentCost();
    }

    public function getShipping()
    {
        return $this->cart->getShipping();
    }

    public function getDeliveryAddress()
    {
        return $this->cart->getDeliveryAddress();
    }

    /**
     * Kosár fejléc létrehozésa ha létezik akkor egy régebbi rendelés alapján.
     */
    private function createCart()
    {
        $this->cart = CartModel::create(
            [
                'Ev' => null,
                'Sorszam' => null,
                'Ugyfel_ID' => $this->customerEmployee->Ugyfel_ID,
                'UgyfelDolgozo_ID' => $this->customerEmployee->UgyfelDolgozo_ID,
                'Fuvar' => null,
                'Deviza_ID' => app('User')->getCurrencyID(),
                'FizetesiMod_ID' => (new CustomerRepository())->getPaymentMethodIdById($this->customerEmployee->Ugyfel_ID),
                'SzemAtvevohely_ID' => null,
                'Szallitas' => Shipping::WHOLE,
                'Visszaru' => 0,
                'Megjegyzes' => null,
            ]
        );
    }

    /**
     * Termék adatainak összevadászása a későbbi felhasználáshoz.
     *
     * @param mixed $qty
     *
     * @return \stdClass
     */
    private function getProductData(Product $product, $qty)
    {
        $prices = $product->getPrices();

        $data = new \stdClass();
        $data->Kod = $product->Kod;
        $data->Nev = $product->Nev;
        $data->ListaAr = $prices->ListaAr;
        $data->AkciosAr = $prices->AkciosAr;
        $data->UgyfelAr = $prices->UgyfelAr;
        $data->SzallHatarido = $product->getDeliveryTime($qty)->getDateTime();

        return $data;
    }

    private function total(Price $price = null)
    {
        return $price ? $price->exchange($this->cart->Deviza_ID)->getTotal() : null;
    }
}
