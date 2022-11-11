<?php

namespace App\Rules;

use App\Repositories\ShippingAddressRepository;
use Illuminate\Contracts\Validation\Rule;

class ContactInformations implements Rule
{
    public function passes($attribute, $value)
    {
        $conditions = ['Ugyfel_ID' => app('User')->getCustomer()->Ugyfel_ID];

        if (! $value) {
            $conditions['AlapCim'] = 1;
        } else {
            $conditions['UgyfelCim_ID'] = $value;
        }

        $shippingAddress = (new ShippingAddressRepository())->findByParameters($conditions)->toArray();

        $requiredFields = [
            'Nev',
            'Orszag_ID',
            'Helyseg',
            'UtcaHSzam',
            'IrSzam',
            'Telefon',
        ];

        foreach ($shippingAddress as $key => $value) {
            if (in_array($key, $requiredFields) && is_null($value)) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return __('validation.required_contact_informations');
    }
}
