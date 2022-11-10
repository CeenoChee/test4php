<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerEmployeeCategoryItem extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'ugyfel_dolgozo_kategoria_tetel';

    protected $primaryKey = [
        'UgyfelDolgozoKategoria_ID',
        'UgyfelDolgozoKategoriaTetel_ID',
    ];

    protected $fillable = [
        'UgyfelDolgozoKategoria_ID',
        'UgyfelDolgozoKategoriaTetel_ID',
        'Kod',
        'Nev',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CustomerEmployeeCategory::class, 'UgyfelDolgozoKategoria_ID');
    }

    public function getName()
    {
        if ($this->UgyfelDolgozoKategoria_ID == CustomerEmployeeCategory::PERMISSION_TAKE_OVER_CATEGORY_ID && $this->Kod == 'IGEN') {
            return 'Árut átvehet';
        }

        if ($this->UgyfelDolgozoKategoria_ID == CustomerEmployeeCategory::EMAIL_NOTIFICATION_CATEGORY_ID && $this->Kod == 'ES') {
            return 'E-számla';
        }

        if ($this->UgyfelDolgozoKategoria_ID == CustomerEmployeeCategory::EMAIL_NOTIFICATION_CATEGORY_ID && $this->Kod == 'FF') {
            return 'Fizetési felszólítás';
        }

        return $this->Nev;
    }
}
