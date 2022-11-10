<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class OrderItemConfirmation extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;

    protected $table = 'order_item_confirmation';

    protected $primaryKey = [
        'AruforgBiz_ID',
        'AruforgBizTetel_ID',
        'AruforgBizTetelVisszaigazolas_ID',
    ];
}
