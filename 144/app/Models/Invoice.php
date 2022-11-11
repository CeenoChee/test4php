<?php

namespace App\Models;

use App\Libs\Enums\Payment;
use App\Libs\LUrl;
use App\Libs\Price;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use Compoships;

    protected $table = 'vevo_sz';
    protected $primaryKey = 'VevoSz_ID';

    protected $fillable = [
        'VevoSz_ID',
        'Ev',
        'Sorozat',
        'Sorszam',
        'Ugyfel_ID',
        'UgyfelDolgozo_ID',
        'UgyfelTelephely_ID',
        'FizetesiMod_ID',
        'Vegosszeg',
        'Deviza_ID',
        'Statusz',
        'SzamlaDatum',
        'TeljesitesDatum',
        'EsedekessegDatum',
        'FelvDatum',
        'ModDatum',
    ];

    public function getNumber()
    {
        return $this->Ev . '-' . $this->Sorozat . '/' . str_pad($this->Sorszam, 6, '0', STR_PAD_LEFT);
    }

    public function getPayment()
    {
        return new Payment($this->FizetesiMod_ID);
    }

    public function getInvoiceStatus()
    {
        // return new szamlaStatusz($this->EsemenyTipus);
    }

    public function getFulfillmentDate()
    {
        return date('Y-m-d', strtotime($this->TeljesitesDatum));
    }

    public function getIssueDate()
    {
        return date('Y-m-d', strtotime($this->SzamlaDatum));
    }

    public function getPaymentDeadline()
    {
        return date('Y-m-d', strtotime($this->EsedekessegDatum));
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'Ugyfel_ID', 'Ugyfel_ID');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'Deviza_ID', 'Deviza_ID');
    }

    public function customerEmployee()
    {
        return $this->belongsTo(CustomerEmployee::class, ['Ugyfel_ID', 'UgyfelDolgozo_ID'], ['Ugyfel_ID', 'UgyfelDolgozo_ID']);
    }

    public function customerPremise()
    {
        return $this->belongsTo(CustomerPremise::class, ['Ugyfel_ID', 'UgyfelTelephely_ID'], ['Ugyfel_ID', 'UgyfelTelephely_ID']);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'VevoSz_ID', 'VevoSz_ID');
    }

    public function formattedSumTotal()
    {
        return number_format($this->Vegosszeg, 2, ',', ' ');
    }

    public function getItemAmount()
    {
        $total = new Price(0, $this->Deviza_ID);

        foreach ($this->items as $item) {
            $total = $total->add($item->getRowTotal());
        }

        return $total;
    }

    public function getTotal()
    {
        return new Price($this->Vegosszeg, $this->Deviza_ID);
    }

    public function getVatTotal()
    {
        $total = $this->items->reduce(fn ($carry, $item) => $carry + $item->AfaErtek, 0);

        return new Price($total, $this->Deviza_ID);
    }

    public function getShowRoute()
    {
        return LUrl::route('invoices.show', [
            'Ev' => $this->Ev,
            'Sorozat' => $this->Sorozat,
            'Sorszam' => $this->Sorszam,
        ]);
    }

    public function getPdfRoute()
    {
        return LUrl::route('invoices.pdf', [
            'Ev' => $this->Ev,
            'Sorozat' => $this->Sorozat,
            'Sorszam' => $this->Sorszam,
        ]);
    }

    public function getVatValues()
    {
        $values = [];

        $this->items->groupBy(function ($item) {
            return $item->getVatRate();
        })->each(function ($items, $key) use (&$values) {
            $values[$key] = new Price($items->reduce(fn ($carry, $item) => $carry + $item->AfaErtek, 0), $this->Deviza_ID);
        });

        return $values;
    }

    public function getCustomerAddress()
    {
        return $this->customer->getAddress();
    }
}
