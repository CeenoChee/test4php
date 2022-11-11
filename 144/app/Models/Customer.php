<?php

namespace App\Models;

use App\Libs\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public const CREATED_AT = 'FelvDatum';
    public const UPDATED_AT = 'ModDatum';

    public $incrementing = false;

    protected $table = 'ugyfel';
    protected $primaryKey = 'Ugyfel_ID';

    public function country()
    {
        return $this->belongsTo(Country::class, 'Orszag_ID');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'Ugynok_ID');
    }

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class, 'Ugyfel_ID');
    }

    public function getAddress()
    {
        return Address::create($this);
    }

    public function isForeigner()
    {
        return $this->Orszag_ID != 0;
    }

    public function customerEmployees()
    {
        return $this->hasMany(CustomerEmployee::class, 'Ugyfel_ID', 'Ugyfel_ID');
    }

    public function invitedUsers()
    {
        return $this->hasMany(User::class, 'invite_customer_id', 'Ugyfel_ID');
    }

    public function getFormattedTaxNumber()
    {
        return collect([
            substr($this->Adoszam, 0, 8),
            substr($this->Adoszam, 8, 1),
            substr($this->Adoszam, 9, 2),
        ])->filter()->implode('-');
    }
}
