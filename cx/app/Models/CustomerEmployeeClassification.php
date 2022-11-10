<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class CustomerEmployeeClassification extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'ugyfel_dolgozo_besorolas';

    protected $primaryKey = [
        'Ugyfel_ID',
        'UgyfelDolgozo_ID',
        'UgyfelDolgozoKategoria_ID',
        'UgyfelDolgozoKategoriaTetel_ID',
    ];

    protected $fillable = [
        'Ugyfel_ID',
        'UgyfelDolgozo_ID',
        'UgyfelDolgozoKategoria_ID',
        'UgyfelDolgozoKategoriaTetel_ID',
    ];
}
