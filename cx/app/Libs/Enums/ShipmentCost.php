<?php

namespace App\Libs\Enums;

class ShipmentCost extends Enum
{
    public const CUSTOMER = 1; // vevo
    public const SUPPLIER_FREE = 2; // szallito_dijmentes
    public const SUPPLIER_FIX = 3; // szallito_fix

    protected function getLabels(): array
    {
        return [
            self::CUSTOMER => trans('pages/orders.store'),
            self::SUPPLIER_FREE => trans('pages/orders.delivery'),
            self::SUPPLIER_FIX => trans('pages/orders.delivery'),
        ];
    }
}
