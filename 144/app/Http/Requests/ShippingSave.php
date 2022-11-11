<?php

namespace App\Http\Requests;

use App\Models\PickupLocation;
use App\Rules\ContactInformations;
use Illuminate\Foundation\Http\FormRequest;

class ShippingSave extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return app('User')->isRielActive();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'atvetel' => 'required|in:atvetel_kiszallitas,atvetel_szemelyes_atvetel',
            'szallitas' => 'required|in:szallitas_tetelresz,szallitas_egesz',
        ];

        if ($this->atvetel === 'atvetel_szemelyes_atvetel') {
            $rules['atvevohely'] = 'required|exists:' . app(PickupLocation::class)->getTable() . ',SzemAtvevohely_ID';

            return $rules;
        }

        $rules['UgyfelCim_ID'] = [
            'in:' . implode(',', $this->getAvailableShippingAddresses()),
            new ContactInformations(),
        ];

        $rules['visszaru'] = 'required|in:visszaru_igen,visszaru_nem';

        return $rules;
    }

    public function messages()
    {
        return [
            'atvetel.required' => 'A átvételi mód kiválasztása kötelező.',
            'szallitas.required' => 'A résszállítás megadása kötelező.',
            'atvevohely.required' => 'A átvételi hely kiválasztása kötelező.',
            // 'address.required' => 'A cím kiválasztása kötelező.',
            'visszaru.required' => 'A visszárú megadása kötelező.',
        ];
    }

    private function getAvailableShippingAddresses(): array
    {
        return array_merge(
            app('User')
                ->getCustomer()
                ->shippingAddresses()
                ->pluck('UgyfelCim_ID')
                ->toArray(),
            ['new']
        );
    }
}
