<?php

namespace App\Models;

use App\Libs\Address;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerPremise extends Model
{
    use HasFactory;
    use Compoships;

    public const CREATED_AT = 'FelvDatum';
    public const UPDATED_AT = 'ModDatum';

    protected $table = 'ugyfel_telephely';

    protected $guarded = [];

    public function getAddress()
    {
        return Address::create($this);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'Orszag_ID');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'Ugynok_ID');
    }
}
