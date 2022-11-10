<?php

namespace App\Libs;

use App\Libs\Enums\Shipping;
use App\Models\Country;

class ShipmentCost
{
    private $country;
    private $shipping;
    private $price;
    private $currencyID;

    public function getCurrencyID()
    {
        if ($this->currencyID === null) {
            $this->currencyID = app('User')->getCurrencyID();
        }

        return $this->currencyID;
    }

    public function setCurrencyID($currencyID)
    {
        $this->currencyID = $currencyID;

        return $this;
    }

    public function setPrice(Price $price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice()
    {
        if ($this->price === null) {
            $this->price = new Price(0, $this->getCurrencyID());
        }

        return $this->price;
    }

    public function setCountry(Country $country)
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry()
    {
        if ($this->country === null) {
            $this->country = app('User')->getCountry();
        }

        return $this->country;
    }

    public function setShipping(Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    public function getShipping()
    {
        if ($this->shipping === null) {
            $this->shipping = new Shipping(Shipping::WHOLE);
        }

        return $this->shipping;
    }

    public function getCost(): Price
    {
        $country = $this->getCountry();

        // Az árat euróban vizsgáljuk meg.
        $eurPriceTotal = $this->getPrice()->exchange(5)->getTotal();

        switch ($country->KodAlpha2) {
            case 'HU':
                return new Price(0, $this->getCurrencyID());

            case 'SK':
            case 'SI':
            case 'AT':
            case 'CZ':
            case 'RO':
            case 'HR':
                if ($eurPriceTotal < 500) {
                    return new Price(10, 5);
                }

                return new Price(0, 5);

            case 'PL':
            case 'DE':
            case 'BE':
            case 'NL':
            case 'LU':
            case 'LI':
            case 'BG':
            case 'CH':
                if ($eurPriceTotal < 750) {
                    return new Price(15, 5);
                }

                return new Price(0, 5);

            case 'DK':
            case 'FR':
            case 'VA':
            case 'IT':
            case 'GB':
            case 'MC':
            case 'IE':
                if ($eurPriceTotal < 1000) {
                    return new Price(20, 5);
                }

                return new Price(0, 5);

            case 'LT':
            case 'LV':
            case 'ES':
            case 'SE':
            case 'EE':
            case 'NO':
            case 'GR':
            case 'PT':
            case 'FI':
                return new Price(30, 5);

            default:
                return new Price(100, 5);
        }
    }
}
