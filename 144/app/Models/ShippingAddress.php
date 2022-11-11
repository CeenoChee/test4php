<?php

namespace App\Models;

use App\Libs\Address;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasCompositePrimaryKey;

    protected $primaryKey = [
        'Ugyfel_ID',
        'UgyfelCim_ID',
    ];

    protected $guarded = [];

    public function __toString()
    {
        return (string) $this->getAddress();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'Orszag_ID');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'Ugyfel_ID');
    }

    public function getAddress()
    {
        return Address::create($this);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'Ugynok_ID');
    }
}
