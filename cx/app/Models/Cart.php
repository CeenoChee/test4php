<?php

namespace App\Models;

use App\Libs\Address;
use App\Libs\Enums\Payment;
use App\Libs\Enums\ReceptionType;
use App\Libs\Enums\ShipmentCost;
use App\Libs\Enums\Shipping;
use App\Libs\Price;
use App\Repositories\CountryRepository;
use App\Repositories\SettingRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use stdClass;

class Cart extends Model
{
    public const SERIAL = 'RN';
    public $timestamps = true;

    protected $table = 'kosar';
    protected $primaryKey = 'Kosar_ID';

    protected $guarded = [];

    public function scopeOpened($query)
    {
        return $query->whereNull('Ev')->whereNull('Sorszam');
    }

    public function scopeClosed($query)
    {
        return $query->whereNotNull('Ev')->whereNotNull('Sorszam');
    }

    public function scopeWhereCustomer($query, Customer $ugyfel)
    {
        return $query->where('Ugyfel_ID', $ugyfel->Ugyfel_ID);
    }

    public function scopeWhereCustomerEmployee($query, CustomerEmployee $customerEmployee)
    {
        return $query->where('Ugyfel_ID', $customerEmployee->Ugyfel_ID)->where('UgyfelDolgozo_ID', $customerEmployee->UgyfelDolgozo_ID);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'Kosar_ID')->with('product');
    }

    public function getNumber(): string
    {
        return $this->Ev . '-' . Cart::SERIAL . '/' . str_pad($this->Sorszam, 6, '0', STR_PAD_LEFT);
    }

    public function pickupLocation(): BelongsTo
    {
        return $this->belongsTo(PickupLocation::class, 'SzemAtvevohely_ID');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'Ugyfel_ID');
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(ShippingAddress::class, 'Ugyfel_ID', 'Ugyfel_ID')
            ->where('UgyfelCim_ID', $this->UgyfelCim_ID);
    }

    public function isClosed(): bool
    {
        return ! empty($this->Ev) && ! empty($this->Sorozat);
    }

    public function premise()
    {
        return $this->belongsTo(CustomerPremise::class, 'Ugyfel_ID', 'Ugyfel_ID')
            ->where('UgyfelTelephely_ID', $this->UgyfelTelephely_ID);
    }

    public function getDeliveryAddress()
    {
        if ($this->getShipmentCost()->is(ShipmentCost::CUSTOMER)) {
            return $this->pickupLocation->getAddress();
        }

        if (! is_null($this->Nev)) {
            $address = new stdClass();

            $address->Nev = $this->Nev;
            $address->Orszag_ID = is_numeric($this->Orszag) ? $this->Orszag : (new CountryRepository())->getIdByCode($this->Orszag);
            $address->Helyseg = $this->Helyseg;
            $address->UtcaHSzam = $this->UtcaHSzam;
            $address->IrSzam = $this->IrSzam;

            return Address::create($address);
        }

        return app('User')->getAddress();
    }

    public function getItemAmount(): Price
    {
        $row = CartItem::where('Kosar_ID', $this->Kosar_ID)->groupBy('Kosar_ID')->select(DB::raw('SUM(UgyfelAr * Mennyiseg) AS Osszeg'))->first();

        if ($row) {
            return new Price($row->Osszeg, $this->Deviza_ID);
        }

        return new Price(0, $this->Deviza_ID);
    }

    public function getShipmentAmount(): Price
    {
        return new Price($this->FuvarOsszeg, $this->Deviza_ID);
    }

    public function getTotal(): Price
    {
        return $this->getShipmentAmount()->add($this->getItemAmount());
    }

    public function getShipmentCost(): ShipmentCost
    {
        return new ShipmentCost($this->Fuvar);
    }

    public function getReceptionType(): ReceptionType
    {
        $deliveryType = $this->getShipmentCost();

        if ($deliveryType->is(ShipmentCost::CUSTOMER)) {
            return new ReceptionType(ReceptionType::PERSONAL);
        }

        if ($deliveryType->is(ShipmentCost::SUPPLIER_FREE) || $deliveryType->is(ShipmentCost::SUPPLIER_FIX)) {
            return new ReceptionType(ReceptionType::DELIVERY);
        }

        return new ReceptionType(null);
    }

    public function getPayment(): Payment
    {
        return new Payment($this->FizetesiMod_ID);
    }

    public function getShipping(): Shipping
    {
        return new Shipping($this->Szallitas);
    }

    public function getWarehouse()
    {
        $shipmentCost = $this->getShipmentCost();

        if ($shipmentCost->is(null)) {
            return null;
        }

        if ($this->getShipmentCost()->is(ShipmentCost::CUSTOMER)) {
            return Warehouse::where('Raktar_ID', $this->SzemAtvevohely_ID)->first();
        }

        return Warehouse::where('Kod', config('riel.warehouse.default'))->first();
    }

    public function order(): ?\App\Libs\Order
    {
        $pdo = DB::getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        DB::beginTransaction();

        try {
            $year = (int) date('Y');

            $lastOrderNumber = (new SettingRepository())->getByKey(Setting::LAST_ORDER_NUMBER);
            if ($lastOrderNumber === null) {
                $cartNumber = Cart::closed()->where('Ev', $year)->max('Sorszam');
                $orderNumber = Order::where('Ev', $year)->where('Sorozat', Cart::SERIAL)->max('Sorszam');

                if ($cartNumber === null and $orderNumber === null) {
                    $orderNumber = 1;
                } elseif ($cartNumber !== null) {
                    $orderNumber = $cartNumber + 1;
                } elseif ($orderNumber !== null) {
                    $orderNumber = $orderNumber + 1;
                } else {
                    $orderNumber = max($cartNumber, $orderNumber) + 1;
                }
            } else {
                $lastOrderNumber = json_decode($lastOrderNumber->value);
                if ($year > (int) $lastOrderNumber->year) {
                    $orderNumber = 1;
                } else {
                    $orderNumber = $lastOrderNumber->number + 1;
                }
            }

            $settingsRepo = new SettingRepository();
            $settingsRepo->createOrUpdate([
                Setting::LAST_ORDER_NUMBER => json_encode([
                    'year' => $year,
                    'number' => $orderNumber,
                ]),
            ]);

            $this->Ev = $year;
            $this->Sorszam = $orderNumber;
            $this->save();

            DB::commit();

            return new \App\Libs\Order($this);
        } catch (Exception $exception) {
            DB::rollBack();

            return null;
        }
    }
}
