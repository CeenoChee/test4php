<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'mennyiseg_egyseg';
    protected $primaryKey = 'MennyisegEgyseg_ID';
    protected $fillable = [
        'MennyisegEgyseg_ID',
        'Nev',
    ];
}
