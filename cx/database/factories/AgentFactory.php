<?php

namespace Database\Factories;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastId = Agent::orderByDesc('Ugynok_ID')->value('Ugynok_ID');

        return [
            'Ugynok_ID' => $lastId ? $lastId + 1 : 1,
            'Nev' => $this->faker->name,
            'Telefon' => $this->faker->phoneNumber,
            'Email' => $this->faker->safeEmail,
        ];
    }
}
