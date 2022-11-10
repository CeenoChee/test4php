<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Knowledge;
use App\Models\KnowledgeCategory;
use App\Models\KnowledgeTranslation;
use App\Models\Language;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class KnowledgeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function has_categories()
    {
        $knowledge = Knowledge::factory()
            ->has(KnowledgeCategory::factory(), 'categories')
            ->create();

        $this->assertInstanceOf(KnowledgeCategory::class, $knowledge->categories()->first());
    }

    /** @test */
    public function has_translations()
    {
        $knowledge = Knowledge::factory()
            ->has(KnowledgeTranslation::factory(), 'translations')
            ->create();

        $this->assertInstanceOf(KnowledgeTranslation::class, $knowledge->translations()->first());
    }

    /** @test */
    public function has_translation()
    {
        $knowledge = Knowledge::factory()
            ->has(KnowledgeTranslation::factory()->state(function () {
                return ['Nyelv_ID' => Language::HU];
            }), 'translations')
            ->create();

        $this->assertInstanceOf(KnowledgeTranslation::class, $knowledge->translation);
    }
}
