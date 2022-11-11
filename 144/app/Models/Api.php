<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Api extends Model
{
    protected $table = 'api';
    protected $primaryKey = 'id';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'Ugyfel_ID');
    }
}
