<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'title' => 'required|max:50',
            'mobile' => 'required',

            'country' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'address' => 'required',

            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',

            'company_name' => 'required',
            'company_registration_number' => 'required',
            'company_tax_number' => 'required',
            'aszf' => 'required',
        ];
    }
}
