<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Download;
use App\Models\Language;
use App\Repositories\DownloadRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DownloadRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected DownloadRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new DownloadRepository();
    }

    /** @test */
    public function a_user_can_search_downloads(){

        $download = Download::factory()->withTranses()->create();

        $expected = $download->trans(Language::HU);

        $this->assertEquals($expected->translatable_id, $this->repo->search($expected->name)->first()->id);


    }




}
