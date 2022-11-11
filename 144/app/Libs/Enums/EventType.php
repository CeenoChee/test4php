<?php

namespace App\Libs\Enums;

class EventType extends Enum
{
    public const EQUIPMENT_FIXED = 3; // berendezes_javitva
    public const EQUIPMENT_NOT_FIXABLE = 4;  // berendezes_nem_javithato
    public const CUSTOMER_RECEIVED = 18; // megrendelo_atvette
    public const DELIVERY = 25;  // kiszallitas

    protected function getLabels()
    {
        return [
            self::EQUIPMENT_FIXED => trans('pages/services.equipment_fixed'),
            self::EQUIPMENT_NOT_FIXABLE => trans('pages/services.equipment_not_fixable'),
            self::CUSTOMER_RECEIVED => trans('pages/services.customer_received'),
            self::DELIVERY => trans('pages/services.delivery'),
        ];
    }
}
