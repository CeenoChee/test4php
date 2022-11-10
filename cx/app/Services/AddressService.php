<?php

namespace App\Services;

use App\Models\CustomerPremise;
use App\Models\ShippingAddress;
use App\Repositories\CustomerPremiseRepository;
use App\Repositories\ShippingAddressRepository;

class AddressService
{
    protected ShippingAddressRepository $shippingAddressRepo;
    protected CustomerPremiseRepository $customerPremiseRepo;

    public function __construct()
    {
        $this->shippingAddressRepo = new ShippingAddressRepository();
        $this->customerPremiseRepo = new CustomerPremiseRepository();
    }

    public function getShippingAddresses($customer, $cart): array
    {
        $addresses = (new ShippingAddressRepository())->getByCustomer($customer)->toArray();

        $hasActiveAddress = false;

        return array_map(function ($address) use ($cart, &$hasActiveAddress) {
            $address['active'] = false;

            if (! is_null($address['UgyfelTelephely_ID'])) {
                $address['id'] = CustomerPremise::where(
                    [
                        ['Ugyfel_ID', $address['Ugyfel_ID']],
                        ['UgyfelTelephely_ID', $address['UgyfelTelephely_ID']],
                    ]
                )->value('id');
            }

            if ($hasActiveAddress) {
                return $address;
            }

            if (! is_null(old('address')) && old('address') === $address['UgyfelCim_ID']) {
                $address['active'] = true;
                $hasActiveAddress = true;

                return $address;
            }

            if ($address['Nev'] == $cart->Nev
                && $address['Orszag_ID'] == $cart->Orszag
                && $address['Helyseg'] == $cart->Helyseg
                && $address['UtcaHSzam'] == $cart->UtcaHSzam
                && $address['IrSzam'] == $cart->IrSzam
            ) {
                $address['active'] = true;
                $hasActiveAddress = true;

                return $address;
            }

            return $address;
        }, $addresses);
    }

    public function addPremisesToCustomer($customer): void
    {
        $customer->premises = $this->customerPremiseRepo->getByCustomerId($customer->Ugyfel_ID, ['agent']);

        $customer->premises->prepend($this->shippingAddressRepo->findByParameters(['Ugyfel_ID' => $customer->Ugyfel_ID, 'AlapCim' => 1]));

        $customer->premises->transform(function ($item) {
            $item->Hasznalhato = $item->Hasznalhato === '1' ? 1 : 0;

            $relatedShippingAddress = $this->shippingAddressRepo->findByParameters(['Ugyfel_ID' => $item->Ugyfel_ID, 'UgyfelTelephely_ID' => $item->UgyfelTelephely_ID]);

            $item->Telefon = $relatedShippingAddress->Telefon;
            $item->Email = $relatedShippingAddress->Email;
            $item->Megjegyzes = $relatedShippingAddress->Megjegyzes;

            return $item;
        });
    }

    public function addPremisesToCustomerForBilling($customer, $cart): void
    {
        $customer->premises = $this->shippingAddressRepo->getPremisesByCustomer($customer)->where('Hasznalhato', 1);

        $customer->premises->transform(function ($item) use ($cart) {
            $item->Hasznalhato = $item->Hasznalhato === '1' ? 1 : 0;

            if ($cart->UgyfelTelephely_ID == $item->UgyfelTelephely_ID) {
                $item->active = true;
            }

            return $item;
        });
    }

    public function addShippingAddressesToCustomer($customer): void
    {
        $customer->shippingAddresses = (new ShippingAddressRepository())->getByCustomer($customer)->whereNull('UgyfelTelephely_ID')->where('AlapCim', 0);

        $customer->shippingAddresses->transform(function ($item) {
            $item->Hasznalhato = $item->Hasznalhato === '1' ? 1 : 0;

            return $item;
        });
    }

    public function refreshShippingAddresses($customer)
    {
        $address = [
            'Nev' => $customer->Nev,
            'Orszag_ID' => $customer->Orszag_ID,
            'Helyseg' => $customer->Helyseg,
            'UtcaHSzam' => $customer->UtcaHSzam,
            'IrSzam' => $customer->IrSzam,
            'Ugynok_ID' => $customer->Ugynok_ID,
        ];

        if ($this->isDefaultShippingAddressExists($customer)) {
            ShippingAddress::where([
                ['Ugyfel_ID', $customer->Ugyfel_ID],
                ['Alapcim', 1],
            ])->update($address);
        } else {
            ShippingAddress::create(array_merge($address, [
                'Ugyfel_ID' => $customer->Ugyfel_ID,
                'UgyfelCim_ID' => (new ShippingAddressRepository())->getMaxShippingAddressIdByCustomerId($customer->Ugyfel_ID) + 1,
                'Szerkesztheto' => 0,
                'AlapCim' => 1,
            ]));
        }

        $customerPremises = CustomerPremise::where('Ugyfel_ID', $customer->Ugyfel_ID)
            ->whereNotNull('UgyfelTelephely_ID')
            ->get();

        foreach ($customerPremises as $customerPremise) {
            $address = [
                'Nev' => $customerPremise->Nev,
                'Orszag_ID' => $customerPremise->Orszag_ID,
                'Helyseg' => $customerPremise->Helyseg,
                'UtcaHSzam' => $customerPremise->UtcaHSzam,
                'IrSzam' => $customerPremise->IrSzam,
                'Hasznalhato' => $customerPremise->Hasznalhato,
                'Ugynok_ID' => $customerPremise->Ugynok_ID,
            ];

            if ($this->isShippingAddressExists($customer, $customerPremise)) {
                ShippingAddress::where([
                    ['Ugyfel_ID', $customer->Ugyfel_ID],
                    ['UgyfelTelephely_ID', $customerPremise->UgyfelTelephely_ID],
                ])->update($address);
            } else {
                ShippingAddress::create(array_merge($address, [
                    'Ugyfel_ID' => $customer->Ugyfel_ID,
                    'UgyfelCim_ID' => (new ShippingAddressRepository())->getMaxShippingAddressIdByCustomerId($customer->Ugyfel_ID) + 1,
                    'UgyfelTelephely_ID' => $customerPremise->UgyfelTelephely_ID,
                ]));
            }
        }

        $this->deleteNonExistentCustomerPremises($customerPremises, $customer);
    }

    private function isDefaultShippingAddressExists($customer): bool
    {
        return ShippingAddress::where([
            ['Ugyfel_ID', $customer->Ugyfel_ID],
            ['Alapcim', 1],
        ])->exists();
    }

    private function isShippingAddressExists($customer, $customerPremise): bool
    {
        return ShippingAddress::where([
            ['Ugyfel_ID', $customer->Ugyfel_ID],
            ['UgyfelTelephely_ID', $customerPremise->UgyfelTelephely_ID],
        ])->exists();
    }

    private function deleteNonExistentCustomerPremises($customerPremises, $customer): void
    {
        $customerPremiseIds = $customerPremises->pluck('UgyfelTelephely_ID')->toArray();

        ShippingAddress::where('Ugyfel_ID', $customer->Ugyfel_ID)
            ->whereNotNull('UgyfelTelephely_ID')
            ->whereNotIn('UgyfelTelephely_ID', $customerPremiseIds)
            ->delete();
    }
}
