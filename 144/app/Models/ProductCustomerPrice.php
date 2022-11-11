<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProductCustomerPrice extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'view_termek_ugyfel_ar';
    protected $primaryKey = [
        'Termek_ID',
        'CsopFizetesiFeltetel_ID',
        'Deviza_ID',
    ];

    public function scopeCurrency($query)
    {
        return $query->where('Deviza_ID', app('User')->getCurrencyID());
    }
}
