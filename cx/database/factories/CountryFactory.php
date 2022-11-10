<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastId = Country::orderByDesc('Orszag_ID')->value('Orszag_ID');

        return [
            'Orszag_ID' => $lastId ? $lastId + 1 : 1,
            'Nev' => $this->faker->country,
            'KodAlpha2' => $this->faker->countryCode,
        ];
    }
}
