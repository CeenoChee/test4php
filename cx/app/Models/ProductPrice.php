<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'view_termek_ar';
    protected $primaryKey = [
        'Termek_ID',
        'Deviza_ID',
    ];

    public function sale()
    {
        return $this->hasMany(Sale::class, 'AkciosAr_ID', 'AkciosAr_ID')->where('Nyelv_ID', app('Lang')->getLanguageId());
    }

    public function scopeCurrency($query)
    {
        return $query->where('Deviza_ID', app('User')->getCurrencyID());
    }
}
