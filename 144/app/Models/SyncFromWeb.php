<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncFromWeb extends Model
{
    public $timestamps = false;

    public $table = 'sync_from_web';
    protected $guarded = [];
}
