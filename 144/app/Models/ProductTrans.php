<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ProductTrans extends Model
{
    use HasCompositePrimaryKey;
    public $timestamps = false;

    protected $table = 'termek_forditas';
    protected $primaryKey = [
        'Termek_ID',
        'Nyelv_ID',
    ];
}
