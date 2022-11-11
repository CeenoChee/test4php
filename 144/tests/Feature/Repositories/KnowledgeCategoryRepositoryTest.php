<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Knowledge;
use App\Models\KnowledgeCategory;
use App\Models\KnowledgeCategoryTranslation;
use App\Models\KnowledgeTranslation;
use App\Repositories\KnowledgeCategoryRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KnowledgeCategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected KnowledgeCategoryRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new KnowledgeCategoryRepository();
    }

    /** @test */
    public function is_able_to_get_knowledge_category_with_active_knowledges_by_slug()
    {
        $knowledgeCategory = $this->createKnowledgeCategory()->first();

        $this->assertInstanceOf(KnowledgeCategory::class, $this->repo->firstActiveBySlug($knowledgeCategory->translation()->first()->slug));
    }

    /** @test */
    public function is_able_to_get_categories_with_active_knowledges()
    {
        $count = 3;

        $this->createKnowledgeCategory($count);

        $this->assertCount($count, $this->repo->getActive());
    }

    private function createKnowledgeCategory(int $count = 1)
    {
        return KnowledgeCategory::factory()
            ->has(
                KnowledgeCategoryTranslation::factory()->state(function () {
                    return ['Nyelv_ID' => app('Lang')->getLanguageId()];
                }),
                'translations'
            )
            ->has(
                Knowledge::factory()
                    ->state(function () {
                        return [
                            'active' => 1,
                            'published_at' => Carbon::now()->subDay(),
                        ];
                    })
                    ->has(
                        KnowledgeTranslation::factory()->state(function () {
                            return ['Nyelv_ID' => app('Lang')->getLanguageId()];
                        }),
                        'translations'
                    ),
                'knowledges'
            )
            ->count($count)
            ->create();
    }
}
