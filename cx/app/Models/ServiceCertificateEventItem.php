<?php

namespace App\Models;

use App\Libs\Price;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ServiceCertificateEventItem extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'szerviz_biz_esemeny_tetel';
    protected $primaryKey = [
        'SzervizBiz_ID',
        'SzervizBizEsemeny_ID',
        'Termek_ID',
    ];
    protected $fillable = [
        'SzervizBiz_ID',
        'SzervizBizEsemeny_ID',
        'Termek_ID',
        'NettoEgysegar',
        'Mennyiseg',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'Termek_ID', 'Termek_ID');
    }

    public function serviceCertificate()
    {
        return $this->belongsTo(ServiceCertificate::class, 'SzervizBiz_ID', 'SzervizBiz_ID');
    }

    public function getNetUnitPrice()
    {
        return new Price($this->NettoEgysegar, $this->serviceCertificate->Deviza_ID);
    }

    public function getNetPrice()
    {
        return $this->getNetUnitPrice()->multiplication($this->Mennyiseg);
    }
}

