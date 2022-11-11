<?php

namespace App\Libs\Enums;

class OrderStatus extends Enum
{
    public const ARRIVED = 0; // Rendelés beérkezett (Homokóra)
    public const TRANSPORTABLE = 1; // Az árú készleten van diszponált állapotban (fuvar=szállító) (teherautó alter) HAMAROSAN SZÁLLÍTJUK
    public const RECEIVABLE = 2; // Az árú készleten van diszponált állapotban (fuvar=vevő) (csomagocska)
    public const IN_TRANSIT = 3; // Készült róla szállítólevél GLS viszi ki (teljesített fuvar=szállító) (teherautó) 3 = 4 3: a futár elindult
    public const RECEIVED = 4; // Készült róla szállítólevél (teljesített fuvar=vevő) (pipa) 4: vevő átvette
    public const REJECTED = 5; // elutasított vagy visszamondott (X)
    public const DELIVERED = 6; // Készült róla szállítólevél GLS viszi ki (teljesített fuvar=szállító gls visszaigazolt) (pipa) átvette a futártól az ügyfél

    protected function getLabels()
    {
        return [
            self::ARRIVED => trans('pages/orders.arrived'),
            self::TRANSPORTABLE => trans('pages/orders.transportable'),
            self::RECEIVABLE => trans('pages/orders.receivable'),
            self::IN_TRANSIT => trans('pages/orders.in_transit'),
            self::RECEIVED => trans('pages/orders.received'),
            self::REJECTED => trans('pages/orders.rejected'),
            self::DELIVERED => trans('pages/orders.delivered'),
        ];
    }
}
