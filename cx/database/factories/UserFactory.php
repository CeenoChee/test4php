<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'Vezeteknev' => $this->faker->lastName,
            'Keresztnev' => $this->faker->firstName,
            'Cegnev' => $this->faker->company,
            'Beosztas' => $this->faker->word,
            'Telefon' => $this->faker->phoneNumber,
            'Mobil' => $this->faker->phoneNumber,
            'Fax' => $this->faker->phoneNumber,
            'Orszag_ID' => Country::factory(),
            'Helyseg' => $this->faker->city,
            'UtcaHSzam' => $this->faker->streetAddress,
            'IrSzam' => $this->faker->postcode,
            'Adoszam' => $this->faker->randomNumber(7),
            'EUAdoszam' => $this->faker->randomNumber(7),
            'Cegjegyzekszam' => $this->faker->randomNumber(7),
            'remember_token' => Str::random(10),
            'token' => Str::random(10),
            'newsletter' => $this->faker->boolean,
        ];
    }
}
