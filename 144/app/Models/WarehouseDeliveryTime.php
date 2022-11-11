<?php


namespace App\Models;


use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDeliveryTime extends Model
{
    use HasFactory;
    use HasCompositePrimaryKey;
    public $timestamps = false;

    protected $table = 'raktar_szall_ido';
    protected $primaryKey = ['ForrasRaktar_ID', 'CelRaktar_ID'];
}
