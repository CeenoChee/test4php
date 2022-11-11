<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class AttributeTrans extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'tulajdonsag_forditas';
    protected $primaryKey = [
        'Tulajdonsag_ID',
        'Nyelv_ID',
    ];
}
