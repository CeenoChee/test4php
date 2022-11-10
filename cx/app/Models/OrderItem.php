<?php

namespace App\Models;

use App\Libs\Price;
use App\Traits\HasCompositePrimaryKey;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;

    protected $table = 'megrendeles_tetel';

    protected $primaryKey = [
        'AruforgBiz_ID',
        'AruforgBizTetel_ID',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'Termek_ID');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'AruforgBiz_ID');
    }

    public function getCustomerPrice()
    {
        return new Price($this->UgyfelAr, $this->order->Deviza_ID);
    }

    public function confirmations()
    {
        return $this->hasMany(OrderItemConfirmation::class, ['AruforgBiz_ID', 'AruforgBizTetel_ID'], ['AruforgBiz_ID', 'AruforgBizTetel_ID']);
    }
}
