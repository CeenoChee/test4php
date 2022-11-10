<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProductClassification extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'termek_besorolas';
    protected $primaryKey = [
        'Termek_ID',
        'TermekKategoria_ID',
        'TermekKategoriaTetel_ID',
    ];
}
