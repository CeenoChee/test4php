<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Models\BannerTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => 1,
            'valid_start' => today()->sub('1 day')->toDateString(),
            'valid_end' => today()->add('1 day')->toDateString(),
        ];
    }

    /**
     * Indicate that the banner is inactive.
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
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Banner $banner) {
            BannerTranslation::factory()->hu()->create([
                'banner_id' => $banner->id,
            ]);

            BannerTranslation::factory()->en()->create([
                'banner_id' => $banner->id,
            ]);
        });
    }
}
