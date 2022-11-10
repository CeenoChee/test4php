<?php

namespace App\Http\Controllers;

use App\Repositories\CountryRepository;
use App\Repositories\CustomerPremiseRepository;
use App\Repositories\SyncFromWebRepository;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected CustomerPremiseRepository $customerPremiseRepo;
    protected SyncFromWebRepository $syncRepo;
    protected AddressService $addressService;

    public function __construct()
    {
        $this->customerPremiseRepo = new CustomerPremiseRepository();
        $this->syncRepo = new SyncFromWebRepository();
        $this->addressService = new AddressService();
    }

    public function index(CountryRepository $countryRepo)
    {
        $customer = app('User')->getCustomer();

        $this->addressService->refreshShippingAddresses($customer);

        $this->addressService->addPremisesToCustomer($customer);
        $this->addressService->addShippingAddressesToCustomer($customer);

        return view('pages.addresses', [
            'countries' => $countryRepo->all()->pluck('Nev', 'Orszag_ID'),
            'customer' => $customer,
        ]);
    }
}
