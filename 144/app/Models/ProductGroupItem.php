<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProductGroupItem extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'termek_kategoria_tetel';
    protected $primaryKey = [
        'TermekKategoria_ID',
        'TermekKategoriaTetel_ID',
    ];
}
