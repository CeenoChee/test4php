<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\KnowledgeCategory;
use App\Models\KnowledgeCategoryTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class KnowledgeCategoryTranslationFactory extends Factory
{
    protected $model = KnowledgeCategoryTranslation::class;

    public function definition()
    {
        return [
            'knowledge_category_id' => KnowledgeCategory::factory(),
            'Nyelv_ID' => Country::factory(),
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
        ];
    }
}
