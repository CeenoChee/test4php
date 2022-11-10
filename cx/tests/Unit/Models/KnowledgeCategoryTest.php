<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Knowledge;
use App\Models\KnowledgeCategory;
use App\Models\KnowledgeCategoryTranslation;
use App\Models\Language;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class KnowledgeCategoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function has_translations()
    {
        $knowledgeCategory = KnowledgeCategory::factory()
            ->has(KnowledgeCategoryTranslation::factory(), 'translations')
            ->create();

        $this->assertInstanceOf(KnowledgeCategoryTranslation::class, $knowledgeCategory->translations()->first());
    }

    /** @test */
    public function has_translation()
    {
        $knowledgeCategory = KnowledgeCategory::factory()
            ->has(KnowledgeCategoryTranslation::factory()->state(function () {
                return ['Nyelv_ID' => Language::HU];
            }), 'translations')
            ->create();

        $this->assertInstanceOf(KnowledgeCategoryTranslation::class, $knowledgeCategory->translation);
    }

    /** @test */
    public function has_knowledges()
    {
        $knowledgeCategory = KnowledgeCategory::factory()
            ->has(Knowledge::factory()->count(3), 'knowledges')
            ->create();

        $this->assertInstanceOf(Knowledge::class, $knowledgeCategory->knowledges()->first());
    }
}
