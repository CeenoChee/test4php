<?php

namespace App\Libs;

use App\Libs\DeliveryTime\DeliveryTime;
use App\Libs\Enums\OrderStatus;
use App\Libs\Enums\ShipmentCost;
use App\Models\CartItem;

class OrderItem
{
    public const CANCELLED = 0;
    public const CONFIRMED = 1;
    public const DISPOSED = 2;

    private $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function isOrderItem()
    {
        return $this->item instanceof \App\Models\OrderItem;
    }

    public function isCartItem()
    {
        return $this->item instanceof CartItem;
    }

    public function getCustomerPrice()
    {
        return $this->item->getCustomerPrice();
    }

    public function getQty()
    {
        return $this->item->Mennyiseg;
    }

    public function getRowTotal()
    {
        return $this->getCustomerPrice()->multiplication($this->getQty());
    }

    public function getProductID()
    {
        return $this->item->Termek_ID;
    }

    public function getProduct()
    {
        return $this->item->product;
    }

    public function getDeliveryTime()
    {
        if ($this->isCartItem() && $this->item->cart->Fuvar != ShipmentCost::CUSTOMER && $this->item->SzallHatarido) {
            $dt = new \DateTime($this->item->SzallHatarido);
            $dt->add(new \DateInterval('P1D'));

            return (new DeliveryTime($dt->format('Y-m-d')))->getWorkday();
        }

        return new DeliveryTime($this->item->SzallHatarido);
    }

    public function getStatusItems()
    {
        $statuses = [];

        if ($this->isOrderItem()) {
            if ($this->item->Diszponalt > 0) {
                $status = (object) [];
                $status->Mennyiseg = $this->item->Diszponalt;
                $status->Tipus = self::DISPOSED;
                $status->Nev = trans('pages/orders.disposed');
                $statuses[] = $status;
            }
            foreach ($this->item->confirmations as $confirmation) {
                if ($confirmation->VisszaigazolasDatum) {
                    $status = (object) [];
                    $status->Mennyiseg = $confirmation->Visszaigazolt;
                    $status->Datum = date('Y-m-d', strtotime($confirmation->VisszaigazolasDatum));
                    $status->Tipus = self::CONFIRMED;
                    $status->Nev = trans('pages/orders.confirmed');
                    $statuses[] = $status;
                }
            }
            $cancelled = $this->getCancelledQty();
            if ($cancelled > 0) {
                $status = (object) [];
                $status->Mennyiseg = $cancelled;
                $status->Tipus = self::CANCELLED;
                $status->Nev = trans('pages/orders.cancelled');
                $statuses[] = $status;
            }
        }

        return $statuses;
    }

    public function getCancelledQty()
    {
        return $this->item->Elutasitott = $this->item->Visszamondott;
    }

    public function isItemCancelled(): bool
    {
        foreach ($this->getStatusItems() as $status) {
            if ($status->Tipus == self::CANCELLED) {
                return true;
            }
        }

        return false;
    }

    public function getStatus()
    {
        if ($this->isOrderItem()) {
            $shipmentCost = $this->item->order->getShipmentCost();

            if ($this->item->Mennyiseg == ($this->item->Elutasitott + $this->item->Visszamondott)) {
                return new OrderStatus(OrderStatus::REJECTED);
            }

            $remainingQty = $this->item->Mennyiseg - $this->item->Visszamondott - $this->item->Elutasitott - $this->item->Teljesitett;

            if (($remainingQty == $this->item->Diszponalt) && $this->item->Diszponalt > 0) {
                if ($shipmentCost->is(ShipmentCost::CUSTOMER)) {
                    return new OrderStatus(OrderStatus::RECEIVABLE);
                }

                return new OrderStatus(OrderStatus::TRANSPORTABLE);
            }

            if ($remainingQty == 0 && $this->item->Diszponalt == 0) {
                if ($shipmentCost->is(ShipmentCost::CUSTOMER)) {
                    return new OrderStatus(OrderStatus::RECEIVED);
                }
                // HA GLS visszajelzés kiküldött de nem átvett.
                // return Megrendeles::statusz_szallitas_alatt;
                // GLS visszajelzés van kiküldött és átvett
                return new OrderStatus(OrderStatus::DELIVERED);
            }

            return new OrderStatus(OrderStatus::ARRIVED);
        }

        if ($this->isCartItem()) {
            return new OrderStatus(OrderStatus::ARRIVED);
        }

        return new OrderStatus(OrderStatus::ARRIVED);
    }
}
