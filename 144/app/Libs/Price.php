<?php

namespace App\Libs;

use App\Models\Currency;

class Price
{
    private static $currencies;
    private $amount;
    private $currencyID;

    public function __construct($amount, $currencyID)
    {
        if (self::$currencies === null) {
            self::init();
        }
        $this->amount = $amount;
        $this->currencyID = $currencyID;
    }

    public function __toString()
    {
        $lang = app('Lang')->getLocale();
        if ($lang == 'hu') {
            $decPoint = ',';
            $thousandsSep = ' ';
        } else {
            $decPoint = '.';
            $thousandsSep = ',';
        }

        $currency = $this->getCurrency();
        if ($currency == 'HUF') {
            return number_format($this->amount, $this->getDecimal(), $decPoint, $thousandsSep) . ' Ft';
        }
        if ($currency == 'EUR') {
            return '€ ' . number_format($this->amount, $this->getDecimal(), $decPoint, $thousandsSep);
        }
        if ($currency == 'USD') {
            return '$ ' . number_format($this->amount, $this->getDecimal(), $decPoint, $thousandsSep);
        }

        return number_format($this->amount, $this->getDecimal(), $decPoint, $thousandsSep) . ' ' . $this->getCurrency();
    }

    public function exchange($currencyID)
    {
        if ($this->currencyID == $currencyID) {
            return $this;
        }

        return new Price($this->amount /
            self::$currencies[$currencyID]['DevizaVeteliArfolyam'] *
            self::$currencies[$this->currencyID]['DevizaEladasiArfolyam'], $currencyID);
    }

    public function getTotal()
    {
        return $this->amount;
    }

    public function getRoundedAmount()
    {
        return round($this->amount, $this->getDecimal());
    }

    public function getCurrency()
    {
        return self::$currencies[$this->currencyID]['Deviza'];
    }

    public function getCurrencyID()
    {
        return $this->currencyID;
    }

    public function getDecimal()
    {
        return self::$currencies[$this->currencyID]['Tizedesjegy'];
    }

    public function add(Price $price)
    {
        return new Price($this->amount + $price->exchange($this->currencyID)->getTotal(), $this->currencyID);
    }

    public function multiplication($value)
    {
        return new Price($this->amount * $value, $this->currencyID);
    }

    private static function init()
    {
        self::$currencies = [];
        foreach (Currency::all() as $currency) {
            self::$currencies[$currency->Deviza_ID] = [
                'Deviza' => $currency->Deviza,
                'DevizaVeteliArfolyam' => $currency->DevizaVeteliArfolyam,
                'DevizaEladasiArfolyam' => $currency->DevizaEladasiArfolyam,
                'Tizedesjegy' => $currency->Tizedesjegy,
            ];
        }
    }
}
