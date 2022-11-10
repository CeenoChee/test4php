<?php

namespace App\Models;

use App\Libs\Address;
use Illuminate\Database\Eloquent\Model;

class PickupLocation extends Model
{
    protected $table = 'szem_atvevohely';
    protected $primaryKey = 'SzemAtvevohely_ID';

    public function __toString()
    {
        return (string) $this->getAddress();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'Orszag_ID');
    }

    public function getAddress()
    {
        return Address::create($this);
    }
}
