<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app('User')->isRielActive();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'address_name' => 'required',
            'address_country' => 'required',
            'address_zip_code' => 'required',
            'address_city' => 'required',
            'address_street' => 'required',
            'address_phone' => 'required|phone:AUTO,HU',
            'address_email' => 'email:rfc,dns,spoof|nullable',
            'address_comment' => 'max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'address_name.required' => 'A név megadása kötelező.',
            'address_country.required' => 'Az ország megadása kötelező.',
            'address_zip_code.required' => 'Az irányítószám megadása kötelező.',
            'address_city.required' => 'A város megadása kötelező.',
            'address_street.required' => 'Az utca és házszám megadása kötelező.',
            'address_phone.required' => 'A telefonszám megadása kötelező.',
        ];
    }

    public function attributes(): array
    {
        return [
            'address_email' => 'email',
            'address_name' => 'név',
            'address_orszag' => 'ország',
            'address_zip_code' => 'irányítószám',
            'address_city' => 'város',
            'address_street' => 'cím',
            'address_comment' => 'megjegyzés',
            'address_phone' => 'telefon',
        ];
    }
}
