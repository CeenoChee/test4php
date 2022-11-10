<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public const MAINTENANCE_MODE = 'maintenance_mode';
    public const SITE_MESSAGE = 'site_message';
    public const SITE_MESSAGE_START = 'site_message_start';
    public const SITE_MESSAGE_END = 'site_message_end';
    public const LAST_ORDER_NUMBER = 'last_order_number';

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];
}
