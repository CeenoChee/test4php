<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastId = Currency::orderByDesc('Deviza_ID')->value('Deviza_ID');

        return [
            'Deviza_ID' => $lastId ? $lastId + 1 : 1,
            'Deviza' => $this->faker->currencyCode,
            'Nev' => $this->faker->name,
            'Sorrend' => 0,
            'Tizedesjegy' => 0,
        ];
    }
}
