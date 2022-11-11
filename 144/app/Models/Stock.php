<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'keszlet';
    protected $primaryKey = [
        'Termek_ID',
        'Raktar_ID',
    ];

    public function scopeOwn($query)
    {
        return $query->whereIn('Raktar_ID', Warehouse::getOwnWarehouseIDs());
    }
}
