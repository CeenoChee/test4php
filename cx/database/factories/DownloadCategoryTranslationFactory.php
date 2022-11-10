<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\DownloadCategory;
use App\Models\DownloadCategoryTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DownloadCategoryTranslationFactory extends Factory
{
    protected $model = DownloadCategoryTranslation::class;

    public function definition()
    {
        return [
            'download_category_id' => DownloadCategory::factory(),
            'Nyelv_ID' => Country::factory(),
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'brief' => $this->faker->text,
        ];
    }
}
