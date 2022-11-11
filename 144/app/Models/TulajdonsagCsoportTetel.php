<?php

namespace App\Models;


use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class TulajdonsagCsoportTetel extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'tulajdonsag_csoport_tetel';
    protected $primaryKey = [
        'TulajdonsagCsoport_ID',
        'Tulajdonsag_ID',
    ];

}
