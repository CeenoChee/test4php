<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\VideoCategory;
use App\Repositories\VideoCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VideoCategoryRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected VideoCategoryRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new VideoCategoryRepository();
    }

    /** @test */
    public function it_can_list_the_categories()
    {
        VideoCategory::factory()->count(2)->create();

        $categories = $this->repo->list();

        $this->assertEquals(2, $categories->count());
    }

    /** @test */
    public function it_can_return_with_a_category_by_slug()
    {
        VideoCategory::factory()->create(['slug' => 'test']);

        $this->assertInstanceOf(VideoCategory::class, $this->repo->firstOrFailBySlug('test'));
    }
}
