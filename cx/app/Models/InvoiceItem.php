<?php

namespace App\Models;

use App\Libs\Price;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'vevo_sz_tetel';
    protected $primaryKey = [
        'VevoSz_ID',
        'VevoSzTetel_ID',
    ];
    protected $fillable = [
        'VevoSz_ID',
        'VevoSzTetel_ID',
        'Termek_ID',
        'Szoveg',
        'NettoEgysegar',
        'Mennyiseg',
        'EngedmenySzazalek',
        'EngedmenyOsszeg',
        'NettoErtek',
        'MennyisegEgyseg_ID',
        'AfaKulcs',
        'ModDatum',
        'FelvDatum',
    ];

    protected $vatRates = [
        0 => 0,
        1 => 7,
        2 => 12,
        3 => 25,
        4 => 5,
        5 => 20,
        10 => 10,
        11 => 6,
        12 => 15,
        13 => 18,
        14 => 8,
        15 => 19,
        16 => 9,
        17 => 24,
        18 => 23,
        19 => 8.5,
        20 => 27,
        21 => 14,
        22 => 21,
        23 => 22,
        24 => 9.5,
        25 => 17,
        26 => 2.1,
        27 => 3,
        28 => 4,
        29 => 4.8,
        30 => 5.5,
        31 => 6,
        32 => 13,
        33 => 13.5,
        34 => 16,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'Termek_ID', 'Termek_ID');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'VevoSz_ID', 'VevoSz_ID');
    }

    public function getNetUnitPrice()
    {
        return new Price($this->NettoEgysegar, $this->invoice->Deviza_ID);
    }

    public function getVatRate()
    {
        return $this->vatRates[$this->AfaKulcs];
    }

    public function getRowTotal()
    {
        return new Price($this->NettoErtek, $this->invoice->Deviza_ID);
    }

    public function getQuantity()
    {
        return isDecimal($this->Mennyiseg) ? $this->Mennyiseg : floor($this->Mennyiseg);
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getDiscount()
    {
        if ($this->EngedmenyOsszeg) {
            return new Price($this->EngedmenyOsszeg, $this->invoice->Deviza_ID);
        }

        $percent = $this->EngedmenySzazalek * 100;

        return isDecimal($percent) ? $percent . '%' : floor($percent) . '%';
    }
}
