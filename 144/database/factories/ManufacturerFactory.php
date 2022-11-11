<?php

namespace Database\Factories;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Gyarto_ID' => Manufacturer::max('Gyarto_ID') + 1,
            'Nev' => $this->faker->word,
            'sort' => 1,
            'active' => 1,
            'warranty_active' => 1,
        ];
    }

    /**
     * Indicate that the manufacturer is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'active' => 0,
            ];
        });
    }

    /**
     * Indicate that the manufacturer is inactive on the warranty page.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function warrantyInActive()
    {
        return $this->state(function (array $attributes) {
            return [
                'warranty_active' => 0,
            ];
        });
    }
}
