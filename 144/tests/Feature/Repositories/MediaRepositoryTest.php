<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Media;
use App\Repositories\MediaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MediaRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected MediaRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new MediaRepository();
    }

    /** @test */
    public function it_can_get_a_media_by_filename()
    {
        $filename = 'test.jpg';

        Media::factory()->create(['file_name' => $filename]);

        $this->assertNotNull($this->repo->firstByFilename($filename));

    }


}
