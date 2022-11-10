<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Knowledge;
use App\Models\KnowledgeTranslation;
use App\Repositories\KnowledgeRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KnowledgeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected KnowledgeRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new KnowledgeRepository();
    }

    /** @test */
    public function is_able_to_get_knowledge_by_slug()
    {
        $knowledge = Knowledge::factory()
            ->has(
                KnowledgeTranslation::factory()->state(function () {
                    return ['Nyelv_ID' => app('Lang')->getLanguageId()];
                }),
                'translations'
            )->state(function () {
                return [
                    'active' => 1,
                    'published_at' => Carbon::now()->subDay(),
                ];
            })->create();

        $this->assertInstanceOf(Knowledge::class, $this->repo->firstActiveBySlug($knowledge->translation()->first()->slug));
    }

    /** @test */
    public function is_able_to_get_knowledges_by_keyword()
    {
        $count = 3;
        Knowledge::factory()
            ->has(
                KnowledgeTranslation::factory()->state(function () {
                    return ['Nyelv_ID' => app('Lang')->getLanguageId()];
                }),
                'translations'
            )
            ->state(function () {
                return [
                    'active' => 1,
                    'published_at' => Carbon::now()->subDay(),
                ];
            })
            ->count($count)
            ->create();

        $keyword = 'Test';
        Knowledge::factory()
            ->has(
                KnowledgeTranslation::factory()->state(function () use ($keyword) {
                    return [
                        'title' => $keyword,
                        'Nyelv_ID' => app('Lang')->getLanguageId(),
                    ];
                }),
                'translations'
            )
            ->state(function () {
                return [
                    'active' => 1,
                    'published_at' => Carbon::now()->subDay(),
                ];
            })
            ->create();

        $this->assertCount(1, $this->repo->getActiveByKeyword($keyword));
    }
}
