<?php

namespace App\Models;

use App\Libs\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'Orszag_ID');
    }

    public function inviteCustomer()
    {
        return $this->belongsTo(Customer::class, 'invite_customer_id');
    }

    public function customerEmployee(): HasOne
    {
        return $this->hasOne(CustomerEmployee::class, 'WebLogin', 'email');
    }

    public static function getByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public function getName(): string
    {
        return $this->Vezeteknev . ' ' . $this->Keresztnev;
    }

    public function getAddress(): Address
    {
        return Address::create($this);
    }

    public function getCustomerId()
    {
        return $this->customerEmployee ? (int) $this->customerEmployee->Ugyfel_ID : null;
    }
}
