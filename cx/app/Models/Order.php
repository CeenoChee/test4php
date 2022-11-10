<?php

namespace App\Models;

use App\Libs\Address;
use App\Libs\Enums\Payment;
use App\Libs\Enums\ShipmentCost;
use App\Libs\Enums\Shipping;
use App\Libs\Price;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'megrendeles';
    protected $primaryKey = 'AruforgBiz_ID';

    public function scopeWhereCustomer($query, Customer $ugyfel)
    {
        return $query->where('Ugyfel_ID', $ugyfel->Ugyfel_ID);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'Ugyfel_ID');
    }

    public function scopeWhereCustomerEmployee($query, CustomerEmployee $customerEmployee)
    {
        return $query->where('Ugyfel_ID', $customerEmployee->Ugyfel_ID)->where('UgyfelDolgozo_ID', $customerEmployee->UgyfelDolgozo_ID);
    }

    public function customerEmployee()
    {
        return $this->belongsTo(CustomerEmployee::class, 'Ugyfel_ID')->where('UgyfelDolgozo_ID', $this->UgyfelDolgozo_ID);
    }

    public function getNumber()
    {
        return $this->Ev . '-' . $this->Sorozat . '/' . str_pad($this->Sorszam, 6, '0', STR_PAD_LEFT);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'AruforgBiz_ID');
    }

    public function getDeliveryAddress()
    {
        return new Address($this->SzallNev, $this->SzallOrszag_ID, $this->SzallHelyseg, $this->SzallUtcaHSzam, $this->SzallIrSzam);
    }

    public function getBillingAddress()
    {
        return $this->customer->getAddress();
    }

    public function getShipmentCost()
    {
        return new ShipmentCost($this->Fuvar);
    }

    public function getShipmentAmount()
    {
        return new Price($this->SzallKoltseg, $this->Deviza_ID);
    }

    public function getPayment()
    {
        return new Payment($this->FizetesiMod_ID);
    }

    public function getShipping()
    {
        return new Shipping($this->Szallitas);
    }

    public function premise()
    {
        return $this->belongsTo(CustomerPremise::class, 'Ugyfel_ID', 'Ugyfel_ID')
            ->where('UgyfelTelephely_ID', $this->UgyfelTelephely_ID);
    }
}
