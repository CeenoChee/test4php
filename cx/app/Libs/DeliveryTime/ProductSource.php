<?php

namespace App\Libs\DeliveryTime;

abstract class ProductSource
{
    private $productID;
    private $deliveryTime;
    private $qty;
    private $sourceName = '';

    public function __construct($productID, $deliveryTime, $qty)
    {
        $this->productID = $productID;
        $this->deliveryTime = new DeliveryTime($deliveryTime);
        $this->qty = $qty === null ? null : (int) $qty;
    }

    public function getProductID()
    {
        return $this->productID;
    }

    public function setProductID($productID)
    {
        $this->productID = $productID;
    }

    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime($deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;
    }

    public function getQty()
    {
        return $this->qty;
    }

    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    public function getSourceName()
    {
        return $this->ForrasNev;
    }

    public function setSourceName($sourceName)
    {
        return $this->ForrasNev = $sourceName;
    }
}
