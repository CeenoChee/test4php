<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerPremise;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerPremiseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerPremise::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customer = Customer::factory()->create();

        $lastId = CustomerPremise::where('Ugyfel_ID', $customer->Ugyfel_ID)
            ->orderByDesc('UgyfelTelephely_ID')
            ->value('UgyfelTelephely_ID');

        return [
            'Ugyfel_ID' => $customer->Ugyfel_ID,
            'UgyfelTelephely_ID' => $lastId ? $lastId + 1 : 1,
            'Kod' => 1,
            'Nev' => $this->faker->name,
            'Orszag_ID' => Country::factory()->create(),
            'Helyseg' => $this->faker->city,
            'UtcaHSzam' => $this->faker->streetAddress,
            'IrSzam' => $this->faker->postcode,
            'Ugynok_ID' => Agent::factory()->create(),
        ];
    }
}
