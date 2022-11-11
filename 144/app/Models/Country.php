<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public const CREATED_AT = 'FelvDatum';
    public const UPDATED_AT = 'ModDatum';

    public $incrementing = false;

    protected $table = 'orszag';
    protected $primaryKey = 'Orszag_ID';

    protected $guarded = [];

    public function __toString()
    {
        return $this->Nev;
    }

    public static function getOptions()
    {
        $countries = Country::orderBy('Nev')->pluck('Nev', 'Orszag_ID')->toArray();

        $orderedCountries = [];
        if (isset($countries[0])) {
            $orderedCountries[0] = $countries[0];
        }

        foreach ($countries as $id => $countryName) {
            if ($id != 0) {
                $orderedCountries[$id] = $countryName;
            }
        }

        return $orderedCountries;
    }
}
