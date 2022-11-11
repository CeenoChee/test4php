<?php

namespace App\Libs\DeliveryTime;

class Supply extends ProductSource
{
    private $orderID;
    private $orderItemID;
    private $orderResponseID;
    private $orderResponseItemID;
    private $warehouseID;

    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;
    }

    public function getOrderID()
    {
        return $this->orderID;
    }

    public function setOrderItemID($orderItemID)
    {
        $this->orderItemID = $orderItemID;
    }

    public function getOrderItemID()
    {
        return $this->orderItemID;
    }

    public function setOrderResponseID($orderResponseID)
    {
        $this->orderResponseID = $orderResponseID;
    }

    public function getOrderResponseID()
    {
        return $this->orderResponseID;
    }

    public function setOrderResponseItemID($orderResponseItemID)
    {
        $this->orderResponseItemID = $orderResponseItemID;
    }

    public function getOrderResponseItemID()
    {
        return $this->orderResponseItemID;
    }

    public function setWarehouseID($warehouseID)
    {
        $this->warehouseID = $warehouseID;
    }

    public function getWarehouseID()
    {
        return $this->warehouseID;
    }
}
