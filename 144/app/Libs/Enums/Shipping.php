<?php

namespace App\Libs\Enums;

class Shipping extends Enum
{
    public const WHOLE = 0; // egesz
    public const ITEM_PART = 2; // tetelresz

    protected function getLabels(): array
    {
        return [
            self::WHOLE => trans('pages/orders.whole'),
            self::ITEM_PART => trans('pages/orders.part'),
        ];
    }
}
