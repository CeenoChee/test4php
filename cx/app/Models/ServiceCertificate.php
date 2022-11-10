<?php

namespace App\Models;

use App\Libs\Enums\EventType;
use App\Libs\Price;
use Illuminate\Database\Eloquent\Model;

class ServiceCertificate extends Model
{
    protected $table = 'szerviz_biz';
    protected $primaryKey = 'SzervizBiz_ID';
    protected $fillable = [
        'Ev',
        'Sorozat',
        'Sorszam',
        'Ugyfel_ID',
        'UgyfelDolgozo_ID',
        'Deviza_ID',
        'GySzam',
        'Garancialis',
        'SzervizBerendezes',
        'SzervizTartozekok',
        'BizDatum',
    ];

    public function getNumber()
    {
        return $this->Ev . '-' . $this->Sorozat . '/' . str_pad($this->Sorszam, 6, '0', STR_PAD_LEFT);
    }

    public function serviceCertificateEvent()
    {
        return $this->hasMany(ServiceCertificateEvent::class, 'SzervizBiz_ID', 'SzervizBiz_ID');
    }

    public function serviceCertificateEventItems()
    {
        return $this->hasMany(ServiceCertificateEventItem::class, 'SzervizBiz_ID', 'SzervizBiz_ID');
    }

    public function getNetAmount()
    {
        $amount = new Price(0, $this->Deviza_ID);
        foreach ($this->serviceCertificateEventItems as $serviceCertificateEventItem) {
            $amount = $amount->add($serviceCertificateEventItem->getNetPrice());
        }

        return $amount;
    }

    public function getWorkCreateDate()
    {
        return date('Y-m-d', strtotime($this->FelvDatum));
    }

    public function getEventType()
    {
        $serviceCertificateEvent = $this->serviceCertificateEvent()->orderBy('Datum', 'desc')->first();
        if ($serviceCertificateEvent) {
            return $serviceCertificateEvent->getEventType();
        }

        return new EventType(null);
    }

    public function getSerialNumber()
    {
        return $this->GySzam;
    }

    public function clerk()
    {
        return $this->belongsTo(CustomerEmployee::class, 'Ugyfel_ID', 'Ugyfel_ID')->where('UgyfelDolgozo_ID', $this->UgyfelDolgozo_ID);
    }

    public function getRelatedCertificates()
    {
        return ServiceCertificate::where('GySzam', $this->GySzam)->where('SzervizBiz_ID', '<>', $this->SzervizBiz_ID)->get();
    }

    public function getServiceCertificateNumber()
    {
        return $this->getNumber();
    }

    public function isWarranty()
    {
        return ServiceCertificateEventItem::where('SzervizBiz_ID', $this->SzervizBiz_ID)->where('Garancialis', 0)->count() == 0;
    }

    public function visibleItems()
    {
        $eventType = $this->getEventType();

        return $eventType->is(EventType::EQUIPMENT_FIXED) || $eventType->is(EventType::CUSTOMER_RECEIVED);
    }
}
