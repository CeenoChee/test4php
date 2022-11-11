<?php

namespace App\Repositories;

use App\Models\Country;

class CountryRepository
{
    protected Country $country;

    public function __construct()
    {
        $this->country = new Country();
    }

    public function all()
    {
        return $this->country->all();
    }

    public function getNameById(int $id)
    {
        return $this->country->where('Orszag_ID', $id)->value('Nev');
    }

    public function getCodeByName(string $name)
    {
        return $this->country->where('Nev', $name)->value('KodAlpha2');
    }

    public function getIdByCode(string $code)
    {
        return $this->country->where('KodAlpha2', $code)->value('Orszag_ID');
    }

    public function getCodeById(int $id)
    {
        return $this->country->where('Orszag_ID', $id)->value('KodAlpha2');
    }
}
