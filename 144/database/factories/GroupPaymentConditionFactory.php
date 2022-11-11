<?php

namespace Database\Factories;

use App\Models\GroupPaymentCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupPaymentConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupPaymentCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastId = GroupPaymentCondition::orderByDesc('CsopFizetesiFeltetel_ID')->value('CsopFizetesiFeltetel_ID');

        return [
            'CsopFizetesiFeltetel_ID' => $lastId ? $lastId + 1 : 1,
            'Nev' => $this->faker->name,
        ];
    }
}
