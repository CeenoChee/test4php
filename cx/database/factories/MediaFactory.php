<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    public function definition()
    {
        return [
            'model_type' => '',
            'model_id' => '',
            'name' => $this->faker->name,
            'file_name' => $this->faker->slug . '.jpg',
            'disk' => 'public',
            'collection_name' => 'test',
            'size' => $this->faker->numberBetween(1000, 10000),
            'manipulations' => '[]',
            'custom_properties' => '[]',
            'responsive_images' => '[]',
        ];
    }

    public function toGcs()
    {
        return $this->state(function (array $attributes) {
            return [
                'disk' => 'gcs',
                'conversions_disk' => 'gcs',
            ];
        });
    }
}
