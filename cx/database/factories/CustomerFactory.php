<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\GroupPaymentCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastId = Customer::orderByDesc('Ugyfel_ID')->value('Ugyfel_ID');

        return [
            'Ugyfel_ID' => $lastId ? $lastId + 1 : 1,
            'Nev' => $this->faker->name,
            'Orszag_ID' => Country::factory()->create(),
            'Helyseg' => $this->faker->city,
            'UtcaHSzam' => $this->faker->streetAddress,
            'IrSzam' => $this->faker->postcode,
            'Viszontelado' => $this->faker->boolean,
            'Konkurencia' => $this->faker->boolean,
            'Adoszam' => $this->faker->randomNumber(5),
            'EUAdoszam' => $this->faker->randomNumber(5),
            'KulfoldiAdoszam' => $this->faker->randomNumber(5),
            'Cegjegyzekszam' => $this->faker->randomNumber(5),
            'CsopFizetesiFeltetel_ID' => GroupPaymentCondition::factory()->create(),
            'Deviza_ID' => Currency::factory()->create(),
            'FizetesiMod_ID' => 1,
            'Ugynok_ID' => Agent::factory()->create(),
        ];
    }
}
