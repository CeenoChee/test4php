<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerPremiseRequest;
use App\Libs\User;
use App\Models\CustomerPremise;
use App\Repositories\CustomerPremiseRepository;
use App\Repositories\ShippingAddressRepository;
use App\Repositories\SyncFromWebRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CustomerPremiseController extends Controller
{
    protected CustomerPremiseRepository $customerPremiseRepo;
    protected SyncFromWebRepository $syncRepo;

    public function __construct()
    {
        $this->customerPremiseRepo = new CustomerPremiseRepository();
        $this->syncRepo = new SyncFromWebRepository();
    }

    public function store(CustomerPremiseRequest $request): Model
    {
        $addressData = $this->transformPremiseForCreation($request->all());

        $customerPremise = $this->customerPremiseRepo->create($addressData)->refresh();

        $this->syncRepo->createShippingAddress($addressData);

        return $customerPremise;
    }

    public function update(CustomerPremiseRequest $request, $customerPremiseId): Model
    {
        $customerPremise = $this->customerPremiseRepo->find($customerPremiseId);

        $shippingAddressRepo = new ShippingAddressRepository();
        $relatedShippingAddress = $shippingAddressRepo->findByParameters(['Ugyfel_ID' => $customerPremise->Ugyfel_ID, 'UgyfelTelephely_ID' => $customerPremise->UgyfelTelephely_ID]);
        $relatedShippingAddress->update(['Telefon' => $request->address_phone, 'Email' => $request->address_email, 'Megjegyzes' => $request->address_comment]);

        $customerPremise->load(['country', 'agent']);

        if ($this->premiseHasChanged($customerPremise, $request)) {
            $transformedRequest = $this->transformPremiseForUpdate($request->all());

            $customerPremise = $this->customerPremiseRepo->update($customerPremise, $transformedRequest);

            $syncData = array_merge([
                'id' => $customerPremise->id,
                'Ugyfel_ID' => $customerPremise->Ugyfel_ID,
                'UgyfelTelephely_ID' => $customerPremise->UgyfelTelephely_ID,
            ], $transformedRequest);

            $this->syncRepo->updateShippingAddress($syncData);

            $relatedShippingAddress->update(['is_under_sync' => 1]);

            $customerPremise->update(['UgyfelTelephely_ID' => null]);
        }

        $customerPremise->Telefon = $relatedShippingAddress->Telefon;
        $customerPremise->Email = $relatedShippingAddress->Email;
        $customerPremise->Megjegyzes = $relatedShippingAddress->Megjegyzes;

        return $customerPremise;
    }

    public function checkSyncStatus(Request $request): array
    {
        $syncronizedAddresses = [];

        foreach ($request->address_ids as $addressId) {
            $syncronizedAddress = CustomerPremise::where([
                ['id', $addressId],
                ['UgyfelTelephely_ID', '!=', null],
            ])->first();

            if ($syncronizedAddress) {
                $syncronizedAddresses[$addressId] = $syncronizedAddress->UgyfelTelephely_ID;
            }
        }

        return $syncronizedAddresses;
    }

    public function setActivity(Request $request, CustomerPremise $customerPremise)
    {
        $customerPremise = $this->customerPremiseRepo->update($customerPremise, ['Hasznalhato' => $request->enabled]);

        $syncData = [
            'Ugyfel_ID' => $customerPremise->Ugyfel_ID,
            'UgyfelTelephely_ID' => $customerPremise->UgyfelTelephely_ID,
            'Nev' => $customerPremise->Nev,
            'Orszag_ID' => $customerPremise->Orszag_ID,
            'Helyseg' => $customerPremise->Helyseg,
            'UtcaHSzam' => $customerPremise->UtcaHSzam,
            'IrSzam' => $customerPremise->IrSzam,
            'Hasznalhato' => $customerPremise->Hasznalhato,
        ];

        $this->syncRepo->updateShippingAddress($syncData);
    }

    private function premiseHasChanged(CustomerPremise $customerPremise, CustomerPremiseRequest $request)
    {
        return ! ($customerPremise->Nev == $request->address_name
            && $customerPremise->Orszag_ID == $request->address_country
            && $customerPremise->Helyseg == $request->address_city
            && $customerPremise->UtcaHSzam == $request->address_street
            && $customerPremise->IrSzam == $request->address_zip_code);
    }

    private function transformPremiseForUpdate(array $premise): array
    {
        return [
            'Nev' => $premise['address_name'],
            'Orszag_ID' => $premise['address_country'],
            'Helyseg' => $premise['address_city'],
            'UtcaHSzam' => $premise['address_street'],
            'IrSzam' => $premise['address_zip_code'],
            'Hasznalhato' => in_array($premise['enabled'], ['1', 'true']) ? 1 : 0,
        ];
    }

    private function transformPremiseForCreation(array $premise): array
    {
        $customer = (new User())->getCustomer();

        $lastCode = $this->customerPremiseRepo->getMaxCode($customer->Ugyfel_ID);

        if (! isset($premise['id'])) {
            $code = $lastCode ? $lastCode + 1 : 1;
        } else {
            $code = $lastCode;
        }

        return [
            'Ugyfel_ID' => $customer->Ugyfel_ID,
            'Kod' => $code,
            'Nev' => $premise['address_name'],
            'Orszag_ID' => $premise['address_country'],
            'Helyseg' => $premise['address_city'],
            'UtcaHSzam' => $premise['address_street'],
            'IrSzam' => $premise['address_zip_code'],
            'Ugynok_ID' => $customer->Ugynok_ID,
            'Hasznalhato' => 1,
        ];
    }
}
