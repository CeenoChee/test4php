<?php

namespace App\Libs\DeliveryTime;

class Stock extends ProductSource
{
    private $warehouseID;

    public function setWarehouseID($warehouseID)
    {
        $this->warehouseID = $warehouseID;
    }

    public function getWarehouseID()
    {
        return $this->warehouseID;
    }
}
