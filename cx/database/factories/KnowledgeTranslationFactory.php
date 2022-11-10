<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Knowledge;
use App\Models\KnowledgeTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class KnowledgeTranslationFactory extends Factory
{
    protected $model = KnowledgeTranslation::class;

    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'slug' => $this->faker->slug,
            'brief' => $this->faker->text,
            'body' => $this->faker->randomHtml,
            'body_stripped' => $this->faker->text,
            'knowledge_id' => Knowledge::factory(),
            'Nyelv_ID' => Country::factory(),
        ];
    }
}
