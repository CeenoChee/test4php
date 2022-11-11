<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'raktar';
    protected $primaryKey = 'Raktar_ID';

    public function scopeInner($query)
    {
        return $query->whereIn('Kod', config('riel.warehouse.inner', []));
    }
}
