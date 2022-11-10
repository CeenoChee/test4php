<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ShippingSave;
use App\Libs\Enums\ReceptionType;
use App\Libs\Enums\ShipmentCost as ShipmentCostEnum;
use App\Libs\Enums\Shipping;
use App\Libs\LUrl;
use App\Libs\ShipmentCost;
use App\Models\PickupLocation;
use App\Models\ShippingAddress;
use App\Repositories\CountryRepository;
use App\Repositories\CustomerPremiseRepository;
use App\Repositories\ShippingAddressRepository;
use App\Repositories\SyncFromWebRepository;
use App\Services\AddressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;

class ShippingController extends Controller
{
    protected AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index(CountryRepository $countryRepo)
    {
        if ($redirect = $this->validateShippingPage()) {
            return $redirect;
        }

        $cart = $this->getCart();

        $this->setReceptionType($cart);

        $pickupLocations = $this->getPickupLocations($cart);

        $customer = app('User')->getCustomer();

        $this->addressService->refreshShippingAddresses($customer);

        $customer->shippingAddresses = $this->addressService->getShippingAddresses($customer, $cart);

        if ($cart->getShipping()->is(Shipping::ITEM_PART)) {
            $cart->partial_shipping = 1;
        } elseif ($cart->getShipping()->is(Shipping::WHOLE)) {
            $cart->partial_shipping = 0;
        }

        return view('pages.orders.shipping', [
            'cart' => $cart,
            'countries' => $countryRepo->all()->pluck('Nev', 'Orszag_ID'),
            'pickupLocations' => $pickupLocations,
            'customer' => $customer,
            'addressPickerType' => $this->getAddressPickerType($cart),
        ]);
    }

    public function store(ShippingSave $request): ?RedirectResponse
    {
        $cart = $this->getCart();

        if ($request->atvetel == 'atvetel_kiszallitas') {
            $shipmentCost = new ShipmentCost();
            $shipmentCost->setPrice($cart->getItemAmount());
            $shipmentCost->setCountry($cart->getDeliveryAddress()->getCountry());
            $shipmentCost->setShipping($cart->getShipping());

            // Kiszállítás esetén
            $cart->Fuvar = ($shipmentCost->getCost()->getTotal() > 0 ? ShipmentCostEnum::SUPPLIER_FIX : ShipmentCostEnum::SUPPLIER_FREE);
            $cart->SzemAtvevohely_ID = null;

            $shippingAddress = (new ShippingAddressRepository())
                ->find([
                    'Ugyfel_ID' => app('User')->getCustomer()->Ugyfel_ID,
                    'UgyfelCim_ID' => $request->UgyfelCim_ID,
                ]);

            if ($shippingAddress->Telefon) {
                $phone = $this->formatPhoneByCountry($shippingAddress->Telefon, $shippingAddress->Orszag_ID);
            } else {
                $phone = null;
            }

            $cart->Nev = $shippingAddress->Nev;
            $cart->Orszag = $shippingAddress->Orszag_ID;
            $cart->Helyseg = $shippingAddress->Helyseg;
            $cart->UtcaHSzam = $shippingAddress->UtcaHSzam;
            $cart->IrSzam = $shippingAddress->IrSzam;
            $cart->Telefon = $phone;
            $cart->Email = $shippingAddress->Email;
            $cart->FutarMegjegyzes = $shippingAddress->Megjegyzes;

            $cart->Visszaru = (int) ($request->visszaru == 'visszaru_igen');
        } else {
            // Személyes átvétel esetén
            $cart->Fuvar = ShipmentCostEnum::CUSTOMER;
            $cart->SzemAtvevohely_ID = (int) $request->atvevohely;

            $cart->Nev = null;
            $cart->Orszag = null;
            $cart->Helyseg = null;
            $cart->UtcaHSzam = null;
            $cart->IrSzam = null;
            $cart->Telefon = null;
            $cart->Email = null;
            $cart->FutarMegjegyzes = null;
            $cart->Visszaru = 0;
        }

        if ($request->szallitas == 'szallitas_tetelresz') {
            $cart->Szallitas = Shipping::ITEM_PART;
        } else {
            $cart->Szallitas = Shipping::WHOLE;
        }

        $cart->save();

        app('Cart')->updateShipmentCost();

        return redirect()->route(LUrl::name('checkout'));
    }

    public function delete(Request $request)
    {
        if ($request->page == 'order' && $redirect = $this->validateShippingPage()) {
            return $redirect;
        }

        $shippingAddress = ShippingAddress::where([
            ['Ugyfel_ID', app('User')->getCustomer()->Ugyfel_ID],
            ['UgyfelCim_ID', $request->UgyfelCim_ID],
        ])->firstOrFail();

        $shippingAddress->delete();

        return [
            'error' => false,
            'message' => trans('pages/orders.the_address_deleted'),
        ];
    }

    public function update(AddressRequest $request, $customerAddressId)
    {
        $address = ShippingAddress::where([
            ['Ugyfel_ID', app('User')->getCustomer()->Ugyfel_ID],
            ['UgyfelCim_ID', $customerAddressId],
        ])->first();

        $data = [];

        if ($address->Szerkesztheto) {
            $data = [
                'Nev' => $request->address_name,
                'Orszag_ID' => $request->address_country,
                'Helyseg' => $request->address_city,
                'UtcaHSzam' => $request->address_street,
                'IrSzam' => $request->address_zip_code,
            ];
        }

        if ($address->UgyfelTelephely_ID) {
            $customerPremise = (new CustomerPremiseRepository())->findByCompositeKeys(app('User')->getCustomer()->Ugyfel_ID, $address->UgyfelTelephely_ID);

            $transformedRequest = [
                'Nev' => $request->address_name,
                'Orszag_ID' => $request->address_country,
                'Helyseg' => $request->address_city,
                'UtcaHSzam' => $request->address_street,
                'IrSzam' => $request->address_zip_code,
                'Hasznalhato' => in_array($request->enabled, ['1', 'true']) ? 1 : 0,
            ];

            $customerPremise->update($transformedRequest);

            $syncData = array_merge([
                'Ugyfel_ID' => $customerPremise->Ugyfel_ID,
                'UgyfelTelephely_ID' => $customerPremise->UgyfelTelephely_ID,
            ], $transformedRequest);

            (new SyncFromWebRepository())->updateShippingAddress($syncData);
        }

        $data = array_merge($data, [
            'Telefon' => $request->address_phone,
            'Email' => $request->address_email,
            'Megjegyzes' => $request->address_comment,
        ]);

        $address->update($data);

        $edited = $address->toArray();
        $edited['country'] = $address->country->toArray();
        $edited['active'] = 1;

        return $edited;
    }

    public function storeShippingAddress(AddressRequest $request)
    {
        $customer = app('User')->getCustomer();

        $newShippingAddressID = ShippingAddress::where('Ugyfel_ID', $customer->Ugyfel_ID)
            ->max('UgyfelCim_ID') + 1;

        $address = ShippingAddress::create([
            'AlapCim' => '0',
            'Ugyfel_ID' => $customer->Ugyfel_ID,
            'UgyfelCim_ID' => $newShippingAddressID,
            'Nev' => $request->address_name,
            'Orszag_ID' => $request->address_country,
            'Helyseg' => $request->address_city,
            'UtcaHSzam' => $request->address_street,
            'IrSzam' => $request->address_zip_code,
            'Telefon' => $this->formatPhoneByCountry($request->address_phone, $request->address_country),
            'Email' => $request->address_email,
            'Megjegyzes' => $request->address_comment,
        ]);

        $created = $address->toArray();
        $created['country'] = $address->country->toArray();
        $created['active'] = 1;

        return $created;
    }

    protected function validateShippingPage(): ?RedirectResponse
    {
        $cart = app('Cart');

        $cart->updateShipmentCost();

        if ($cart->isEmpty()) {
            return redirect()->route(LUrl::name('cart'));
        }

        return null;
    }

    private function setReceptionType($cart): void
    {
        if (! is_null(old('atvetel'))) {
            if (old('atvetel') === 'atvetel_szemelyes_atvetel') {
                $cart->reception_type = 'personal';
            } elseif (old('atvetel') === 'atvetel_kiszallitas') {
                $cart->reception_type = 'delivery';
            }
        } else {
            if ($cart->getReceptionType()->is(ReceptionType::DELIVERY)) {
                $cart->reception_type = 'delivery';
            } elseif ($cart->getReceptionType()->is(ReceptionType::PERSONAL)) {
                $cart->reception_type = 'personal';
            }
        }
    }

    private function getCart()
    {
        return app('Cart')->getCart();
    }

    private function getPickupLocations($cart)
    {
        return PickupLocation::all()->map(function ($pickupLocation) use ($cart) {
            $pickupLocation->address = $pickupLocation
                ->getAddress()
                ->withoutName()
                ->getConcatenatedString();

            $pickupLocation->active = $cart->SzemAtvevohely_ID == $pickupLocation->SzemAtvevohely_ID;

            $pickupLocation->iconClass = $pickupLocation->Nev == 'Központ' ? 'fa-shop' : 'fa-warehouse-full';

            return $pickupLocation;
        });
    }

    private function formatPhoneByCountry($phone, $country): string
    {
        $countryCode = (new CountryRepository())->getCodeById($country);
        $phoneFormat = PhoneNumber::make($phone, PhoneNumber::isValidCountryCode($countryCode) ? $countryCode : 'HU');

        return $phoneFormat->formatInternational();
    }

    private function getAddressPickerType($cart): string
    {
        if (is_null($cart->Nev) || (is_null($cart->UgyfelTelephely_ID) && $this->isBillingAndShippingAddressSame($cart->customer, $cart))
            || ! is_null($cart->UgyfelTelephely_ID) && $this->isBillingAndShippingAddressSame($cart->premise, $cart)) {
            return 'copy';
        }

        return 'custom';
    }

    private function isBillingAndShippingAddressSame($address, $cart)
    {
        return $address->Nev == $cart->Nev
            && $address->Orszag_ID == $cart->Orszag
            && $address->Helyseg == $cart->Helyseg
            && $address->UtcaHSzam == $cart->UtcaHSzam
            && $address->IrSzam == $cart->IrSzam;
    }
}
