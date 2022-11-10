<?php

namespace App\Libs\Enums;

class Payment extends Enum
{
    // atutalas
    public const TRANSFER = 0;

    // csekk
    public const CHECK = 2;    // utólag felvitt mód

    // kompenzacio
    public const COMPENSATION = 3;  // utólag felvitt mód

    // keszpenz
    public const CASH = 4;

    // utanvet
    public const CASH_ON_DELIVERY = 7;

    // elorefizetes
    public const PREPAYMENT = 8;

    // l_per_c
    public const L_PER_C = 9;  // utólag felvitt mód

    // helyszinen_bankkartya
    public const ON_THE_SPOT_WITH_CREDIT_CARD = 11;

    // atutalas_szerzodes
    public const TRANSFER_CONTRACT = 12;  // utólag felvitt mód

    // atutalas_scontoval
    public const TRANSFER_WITH_SCONTO = 13;  // utólag felvitt mód

    // bankkartya
    public const CREDIT_CARD = 14;

    protected function getLabels()
    {
        return [
            self::TRANSFER => trans('pages/orders.transfer'),
            self::CHECK => 'csekk',
            self::COMPENSATION => 'kompenzáció',
            self::CASH => trans('pages/orders.cash'),
            self::CASH_ON_DELIVERY => trans('pages/orders.pay_on_delivery'),
            self::PREPAYMENT => trans('pages/orders.prepayment'),
            self::L_PER_C => trans('pages/orders.l_per_c'),
            self::ON_THE_SPOT_WITH_CREDIT_CARD => trans('pages/orders.local_credit_card'),
            self::TRANSFER_CONTRACT => 'Átutalás szerződés',
            self::TRANSFER_WITH_SCONTO => 'Átutalás scontoval',
            self::CREDIT_CARD => trans('pages/orders.credit_card'),
        ];
    }
}
