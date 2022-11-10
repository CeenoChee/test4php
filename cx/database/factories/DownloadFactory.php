<?php

namespace Database\Factories;

use App\Models\Download;
use App\Models\DownloadCategory;
use App\Models\Language;
use App\Models\Media;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DownloadFactory extends Factory
{
    protected $model = Download::class;

    public function definition()
    {
        return [
            'version' => "{$this->faker->randomNumber(1)}.{$this->faker->randomNumber(2)}",
        ];
    }

    public function withCategories()
    {
        return $this->afterCreating(function (Download $download) {
            $download->categories()->sync(DownloadCategory::factory()->withTranses()->count(1)->create()->pluck('id'));
        });
    }

    public function withTranses()
    {
        return $this->afterCreating(function (Download $download) {
            $translatable = ['translatable_id' => $download->id, 'translatable_type' => 'downloads'];

            Translation::factory()->create($translatable + ['language_id' => Language::HU]);
            Translation::factory()->create($translatable + ['language_id' => Language::EN]);
        });
    }

    public function withMedia()
    {
        return $this->afterCreating(function (Download $download) {
            $iconModel = [
                'model_id' => $download->id,
                'model_type' => (new Download())->getMorphClass(),
                'collection_name' => 'icon',
            ];

            $fileModel = [
                'model_id' => $download->id,
                'model_type' => (new Download())->getMorphClass(),
                'collection_name' => 'download',
            ];

            $download->media()->sync([
                Media::factory()->toGcs()->create($iconModel)->id,
                Media::factory()->toGcs()->create($fileModel)->id,
            ]);
        });
    }
}
