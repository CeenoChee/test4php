<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\VideoCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'video_category_id' => VideoCategory::factory()->create(),
            'yid' => $this->faker->slug,
            'title' => $this->faker->word,
            'description' => $this->faker->text,
            'image' => 'test.jpg',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'views' => $this->faker->randomNumber(),
            'likes' => $this->faker->randomNumber(),
            'published_at' => Carbon::now(),
        ];
    }
}
