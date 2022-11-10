<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasCompositePrimaryKey;
    public $timestamps = false;

    protected $table = 'subscriptions';
    protected $primaryKey = [
        'user_id',
        'newsletter_id',
    ];

    protected $guarded = [];
}
