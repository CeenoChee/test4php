<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VideoCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VideoCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->word;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'yid' => $this->faker->slug,
        ];
    }

    public function withVideos()
    {
        return $this->afterCreating(function (VideoCategory $videoCategory) {
            Video::factory()->count(2)->create(['video_category_id' => $videoCategory->id]);
        });
    }
}
