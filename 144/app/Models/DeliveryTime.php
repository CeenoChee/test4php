<?php
/**
 * Created by PhpStorm.
 * User: Molitor
 * Date: 2019. 06. 04.
 * Time: 13:34
 */

namespace App\Models;


use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'szall_hatarido';
    protected $primaryKey = [
        'AruforgBiz_ID',
        'AruforgBizTetel_ID',
        'AruforgBizValasz_ID',
        'AruforgBizValaszTetel_ID',
    ];
}
