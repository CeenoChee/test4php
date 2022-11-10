<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerEmployeeCategory extends Model
{
    public const PERMISSION_TAKE_OVER_CATEGORY_ID = 1;
    public const PERMISSION_WEB_CATEGORY_ID = 6;
    public const EMAIL_NOTIFICATION_CATEGORY_ID = 2;

    protected $table = 'ugyfel_dolgozo_kategoria';
    protected $primaryKey = 'UgyfelDolgozoKategoria_ID';
    protected $fillable = [
        'UgyfelDolgozoKategoria_ID',
        'Nev',
    ];

    public function customerEmployeeCategoryItems(): HasMany
    {
        return $this->hasMany(CustomerEmployeeCategoryItem::class, 'UgyfelDolgozoKategoria_ID')
            ->where('Kod', '!=', 'ES2');
    }
}
