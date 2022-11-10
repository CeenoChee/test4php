<?php

namespace App\Models;

use App\Libs\Price;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasCompositePrimaryKey;

    public $timestamps = true;

    protected $table = 'kosar_tetel';
    protected $primaryKey = [
        'Kosar_ID',
        'Termek_ID',
    ];

    protected $fillable = [
        'Kosar_ID',
        'Termek_ID',
        'Mennyiseg',
        'Kod',
        'Nev',
        'ListaAr',
        'AkciosAr',
        'UgyfelAr',
        'SzallHatarido',
    ];

    public function scopeProduct($query, Product $product)
    {
        return $query->where('Termek_ID', $product->Termek_ID);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'Kosar_ID', 'Kosar_ID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'Termek_ID')->extraData();
    }

    public function getCustomerPrice()
    {
        return new Price($this->UgyfelAr, $this->cart->Deviza_ID);
    }
}
