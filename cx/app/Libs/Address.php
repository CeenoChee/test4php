<?php

namespace App\Libs;

use App\Models\Country;

class Address
{
    private static $countries = [];

    private $name;
    private $countryID;
    private $city;
    private $streetHouseNumber;
    private $postcode;

    public function __construct($name, $countryID, $city, $streetHouseNumber, $postcode)
    {
        $this->name = $name;
        $this->countryID = $countryID;
        $this->city = $city;
        $this->streetHouseNumber = $streetHouseNumber;
        $this->postcode = $postcode;
    }

    public function __toString()
    {
        return $this->getConcatenatedString();
    }

    public function getCountry()
    {
        if ($this->countryID === null) {
            return null;
        }
        if (! array_key_exists($this->countryID, self::$countries)) {
            self::$countries[$this->countryID] = Country::where('Orszag_ID', $this->countryID)->first();
        }

        return self::$countries[$this->countryID];
    }

    public static function create($obj)
    {
        return new self($obj->Nev, $obj->Orszag_ID, $obj->Helyseg, $obj->UtcaHSzam, $obj->IrSzam);
    }

    public function toHtml(): string
    {
        $address = '';

        if ($this->countryID !== null) {
            $address .= $this->getCountry()->Nev . '<br />';
        }

        if ($this->postcode) {
            $address .= $this->postcode . ', ';
        }

        if ($this->city) {
            $address .= $this->city . '<br />';
        }

        $allAddress = [];

        if ($this->name) {
            $allAddress[] = $this->name . '<br />';
        }

        if ($address != '') {
            $allAddress[] = $address;
        }

        if ($this->streetHouseNumber) {
            $allAddress[] = $this->streetHouseNumber;
        }

        $allAddress = implode('', $allAddress);

        if ($allAddress != '') {
            return $allAddress;
        }

        return '';
    }

    public function getFormattedAddress(): string
    {
        $address = $this->getConcatenatedString();
        $addressItems = explode(',', $address);

        if (count($addressItems) > 0) {
            $name = $addressItems[0];
            unset($addressItems[0]);

            return '<span class="font-semibold">' . $name . '</span><br>' . implode(',', $addressItems);
        }

        return '';
    }

    public function getConcatenatedString(): string
    {
        $address = [];

        if ($this->countryID !== null) {
            $address[] = $this->getCountry()->Nev;
        }

        if ($this->postcode) {
            $address[] = $this->postcode;
        }

        if ($this->city) {
            $address[] = $this->city;
        }

        $address = implode(' ', $address);

        $allAddress = [];

        if ($this->name) {
            $allAddress[] = $this->name;
        }

        if ($address != '') {
            $allAddress[] = $address;
        }

        if ($this->streetHouseNumber) {
            $allAddress[] = $this->streetHouseNumber;
        }

        $allAddress = implode(', ', $allAddress);

        if ($allAddress != '') {
            return $allAddress;
        }

        return '';
    }

    public function withoutName()
    {
        return $this->setName('');
    }

    public function withoutCountry()
    {
        return $this->setCountryID(null);
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCountryID($countryID)
    {
        $this->countryID = $countryID;

        return $this;
    }

    public function getCountryID()
    {
        return $this->countryID;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setStreetHouseNumber($streetHouseNumber)
    {
        $this->streetHouseNumber = $streetHouseNumber;

        return $this;
    }

    public function getStreetHouseNumber()
    {
        return $this->streetHouseNumber;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }
}
