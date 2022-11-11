<?php

namespace App\Models;

use App\Libs\Enums\EventType;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ServiceCertificateEvent extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'szerviz_biz_esemeny';
    protected $primaryKey = [
        'SzervizBiz_ID',
        'SzervizBizEsemeny_ID',
    ];
    protected $fillable = [
        'SzervizBizEsemeny_ID',
        'Sorrend',
        'Nev',
        'NettoOsszeg',
        'Datum',
    ];

    public function getEventType()
    {
        return new EventType($this->EsemenyTipus);
    }
}

