<?php

namespace App\Libs\DeliveryTime;

class Manufacture extends ProductSource
{
    public function __construct($productID, $deliveryTime)
    {
        parent::__construct($productID, $deliveryTime, null);
    }
}
