<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Download;
use App\Models\DownloadCategory;
use App\Models\DownloadCategoryTranslation;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class DownloadCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DownloadCategory::class;

    public function definition()
    {
        return [];
    }

    public function withTranses(): DownloadCategoryFactory
    {
        return $this->afterCreating(function (DownloadCategory $downloadCategory) {
            DownloadCategoryTranslation::factory()->create([
                'download_category_id' => $downloadCategory->id,
                'Nyelv_ID' => Language::HU,
            ]);

            DownloadCategoryTranslation::factory()->create([
                'download_category_id' => $downloadCategory->id,
                'Nyelv_ID' => Language::EN,
            ]);
        });
    }

    public function withDownloads(int $count = 1)
    {
        return $this->afterCreating(function (DownloadCategory $downloadCategory) use ($count) {
            $downloadCategory->downloads()->sync(Download::factory()->withTranses()->count($count)->create()->pluck('id'));
        });
    }
}
