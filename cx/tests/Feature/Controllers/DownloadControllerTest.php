<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Models\Download;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DownloadControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setup(): void
    {
        parent::setUp();
    }

    /** @test */
    public function a_user_can_visit_a_download_page()
    {
        $download = Download::factory()->withCategories()->withTranses()->withMedia()->create();

        $response = $this->get(route('hu.download.show', $download));

        $response->assertOk();

        $response->assertViewIs('pages.downloads.show');
    }

    /** @test */
    public function a_user_can_search_downloads()
    {
        Download::factory()->withCategories()->create();

        $response = $this->get(route('hu.download.results') . '?keyword=teszt');

        $response->assertOk();

        $response->assertViewIs('pages.downloads.results');
    }
}
