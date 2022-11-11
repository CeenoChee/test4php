<?php

namespace App\Libs;

use App\Libs\Enums\OrderStatus;
use App\Libs\Enums\Payment;
use App\Libs\Enums\ShipmentCost;
use App\Libs\Enums\Shipping;
use App\Models\Cart;
use App\Models\CustomerEmployee;
use App\Repositories\ShippingAddressRepository;

class Order
{
    private $order;
    private $customerEmployee;

    private $items;

    public function __construct($order)
    {
        $this->order = $order;
        $this->customerEmployee = CustomerEmployee::where('Ugyfel_ID', $this->order->Ugyfel_ID)->where('UgyfelDolgozo_ID', $this->order->UgyfelDolgozo_ID)->first();
    }

    public static function find($year, $serial, $number)
    {
        $order = \App\Models\Order::where('Ev', $year)->where('Sorozat', $serial)->where('Sorszam', (int) $number)->first();

        if ($order) {
            return new self($order);
        }

        if ($serial == Cart::SERIAL) {
            $cart = Cart::closed()->where('Ev', $year)->where('Sorszam', (int) $number)->first();
            if ($cart) {
                return new self($cart);
            }
        }

        return null;
    }

    public static function findOrFail($year, $serial, $number)
    {
        $order = self::find($year, $serial, $number);

        if (! $order) {
            abort(404);
        }

        return $order;
    }

    public function isOrder()
    {
        return $this->order instanceof \App\Models\Order;
    }

    public function isCart()
    {
        return $this->order instanceof Cart;
    }

    public function getNumber()
    {
        if ($this->order->Ev) {
            return $this->order->getNumber();
        }

        return null;
    }

    public function getYear()
    {
        return $this->order->Ev;
    }

    public function getSerial()
    {
        if ($this->isCart()) {
            return Cart::SERIAL;
        }

        return $this->order->Sorozat;
    }

    public function getSerialNumber()
    {
        return $this->order->Sorszam;
    }

    public function getShipmentCost()
    {
        return new ShipmentCost((int) $this->order->Fuvar);
    }

    public function getPayment()
    {
        return new Payment((int) $this->order->FizetesiMod_ID);
    }

    public function getShipping()
    {
        return new Shipping((int) $this->order->Szallitas);
    }

    public function getShipmentAmount()
    {
        return $this->order->getShipmentAmount();
    }

    public function getUpdateDate()
    {
        if ($this->isOrder()) {
            return date('Y-m-d', strtotime($this->order->ModDatum));
        }
        if ($this->isCart()) {
            return date('Y-m-d', strtotime($this->order->updated_at));
        }

        return null;
    }

    public function getCreateDate()
    {
        if ($this->isOrder()) {
            return date('Y-m-d', strtotime($this->order->FelvDatum));
        }
        if ($this->isCart()) {
            return date('Y-m-d', strtotime($this->order->updated_at));
        }

        return null;
    }

    public function getDate()
    {
        return $this->getCreateDate();
    }

    public function getItems()
    {
        if ($this->items === null) {
            $this->items = [];
            if ($this->isOrder()) {
                foreach ($this->order->items as $orderItem) {
                    $this->items[] = new OrderItem($orderItem);
                }
            } elseif ($this->isCart()) {
                foreach ($this->order->items as $cartItem) {
                    $this->items[] = new OrderItem($cartItem);
                }
            }
        }

        return $this->items;
    }

    public function getStatus()
    {
        $status = OrderStatus::DELIVERED;
        foreach ($this->getItems() as $item) {
            $itemStatus = $item->getStatus();
            if ($itemStatus) {
                $status = min($status, $item->getStatus()->getValue());
            }
        }

        return new OrderStatus($status);
    }

    public function getItemAmount()
    {
        $total = new Price(0, $this->order->Deviza_ID);
        foreach ($this->getItems() as $item) {
            $total = $total->add($item->getRowTotal());
        }

        return $total;
    }

    public function getTotal()
    {
        return $this->getItemAmount()->add($this->getShipmentAmount());
    }

    public function getCustomerEmployee()
    {
        return $this->customerEmployee;
    }

    public function getName()
    {
        if ($this->customerEmployee) {
            return $this->customerEmployee->Nev;
        }

        return '';
    }

    public function getPhone()
    {
        if ($this->customerEmployee) {
            return $this->customerEmployee->Telefon;
        }

        return '';
    }

    public function getMobile()
    {
        if ($this->customerEmployee) {
            return $this->customerEmployee->Mobil;
        }

        return '';
    }

    public function getEmail()
    {
        if ($this->customerEmployee) {
            return $this->customerEmployee->WebLogin;
        }

        return '';
    }

    public function getBillingAddress()
    {
        $billingAddress = (new ShippingAddressRepository())->findByParameters(['Ugyfel_ID' => $this->order->Ugyfel_ID, 'UgyfelTelephely_ID' => $this->order->UgyfelTelephely_ID]);

        return Address::create($billingAddress);
    }

    public function getDeliveryAddress()
    {
        if ($this->isOrder() || $this->isCart()) {
            return $this->order->getDeliveryAddress();
        }

        return null;
    }

    public function getComment()
    {
        if ($this->order) {
            return $this->order->Megjegyzes;
        }

        return '';
    }

    public function getShippingComment()
    {
        if ($this->order) {
            return $this->order->FutarMegjegyzes;
        }

        return null;
    }

    public function getShippingPhone()
    {
        if ($this->order) {
            return $this->order->Telefon;
        }

        return null;
    }

    public function getShippingEmail()
    {
        if ($this->order) {
            return $this->order->Email;
        }

        return null;
    }

    public function getReturnGoods()
    {
        if ($this->order) {
            return $this->order->Visszaru;
        }

        return '';
    }

    public function getAvailableStatuses(): array
    {
        if ($this->order->Fuvar == 1) {
            return [
                new OrderStatus(OrderStatus::ARRIVED),
                new OrderStatus(OrderStatus::RECEIVABLE),
                new OrderStatus(OrderStatus::RECEIVED),
            ];
        }

        return [
            new OrderStatus(OrderStatus::ARRIVED),
            new OrderStatus(OrderStatus::TRANSPORTABLE),
            new OrderStatus(OrderStatus::IN_TRANSIT),
            new OrderStatus(OrderStatus::DELIVERED),
        ];
    }
}
