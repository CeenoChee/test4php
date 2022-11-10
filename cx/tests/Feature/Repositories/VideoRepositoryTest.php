<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Video;
use App\Models\VideoCategory;
use App\Repositories\VideoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VideoRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected VideoRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new VideoRepository();
    }

    /** @test */
    public function it_can_search_the_videos(){

        Video::factory()->create(['title' => 'testVideo']);
        Video::factory()->count(2)->create();

        $videos = $this->repo->search('testVi');

        $this->assertEquals(1, $videos->count());
    }


}
