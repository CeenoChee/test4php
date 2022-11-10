<?php

namespace App\Libs\Enums;

class ReceptionType extends Enum
{
    public const DELIVERY = 1;
    public const PERSONAL = 2;

    protected function getLabels(): array
    {
        return [
            self::DELIVERY => trans('pages/orders.delivery'),
            self::PERSONAL => trans('pages/orders.store'),
        ];
    }
}
