<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'link' => $this->faker->url(),
            'description' => $this->faker->realText(),
            // 'banner_id' => Banner::factory(),
            'Nyelv_ID' => Language::HU,
        ];
    }

    /**
     * Indicate that the banner is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function hu()
    {
        return $this->state(function (array $attributes) {
            return [
                'Nyelv_ID' => Language::HU,
            ];
        });
    }

    /**
     * Indicate that the banner is inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function en()
    {
        return $this->state(function (array $attributes) {
            return [
                'Nyelv_ID' => Language::EN,
            ];
        });
    }
}
