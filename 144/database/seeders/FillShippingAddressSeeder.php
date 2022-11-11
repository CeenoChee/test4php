<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FillShippingAddressSeeder extends Seeder
{
    public function run()
    {
        $customers = DB::table('ugyfel')
            ->select(
                'Ugyfel_ID',
                'Nev',
                'Orszag_ID',
                'Helyseg',
                'UtcaHSzam',
                'IrSzam',
                'Ugynok_ID'
            )
            ->get()
            ->toArray();

        $customers = array_map(function ($address) {
            return (array) $address;
        }, $customers);

        foreach ($customers as $key => $customer) {
            $customers[$key]['UgyfelCim_ID'] = 1;
            $customers[$key]['UgyfelTelephely_ID'] = null;
            $customers[$key]['AlapCim'] = 1;
            $customers[$key]['Hasznalhato'] = 1;
        }

        $customerPremises = DB::table('ugyfel_telephely')
            ->select(
                'Ugyfel_ID',
                'UgyfelTelephely_ID',
                'Nev',
                'Orszag_ID',
                'Helyseg',
                'UtcaHSzam',
                'IrSzam',
                'Hasznalhato',
                'Ugynok_ID'
            )
            ->get()
            ->toArray();

        $customerPremises = array_map(function ($address) {
            return (array) $address;
        }, $customerPremises);

        foreach ($customerPremises as $key => $customerPremise) {
            $customerPremisesWithUgyfelCimId = array_filter($customerPremises, function ($customerPrem) use ($customerPremise) {
                return $customerPrem['Ugyfel_ID'] === $customerPremise['Ugyfel_ID'] && isset($customerPrem['UgyfelCim_ID']);
            });

            if (count($customerPremisesWithUgyfelCimId) > 0) {
                $customerPremises[$key]['UgyfelCim_ID'] = max(array_column($customerPremisesWithUgyfelCimId, 'UgyfelCim_ID')) + 1;
            } else {
                $customerPremises[$key]['UgyfelCim_ID'] = 2;
            }

            $customerPremises[$key]['AlapCim'] = 0;
        }

        $addresses = array_merge($customers, $customerPremises);

        foreach ($addresses as $key => $address) {
            $addresses[$key]['Szerkesztheto'] = 0;
        }

        DB::table('shipping_addresses')->insert($addresses);
    }
}
