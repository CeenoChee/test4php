<?php

namespace Database\Factories;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'name' => $name,
            'language_id' => rand(0, 2),
            'slug' => Str::slug($name),
            'description' => $this->faker->text,
        ];
    }
}
