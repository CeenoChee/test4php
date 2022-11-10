<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\DownloadCategory;
use App\Models\Language;
use App\Repositories\DownloadCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DownloadCategoryRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected DownloadCategoryRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new DownloadCategoryRepository();
    }

    /** @test */
    public function it_can_get_the_download_group_list()
    {
        DownloadCategory::factory()->count(3)->create();

        $this->assertTrue($this->repo->list()->count() >= 3);
    }

}
