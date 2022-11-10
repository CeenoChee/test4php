<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Models\DownloadCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DownloadCategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setup(): void
    {
        parent::setUp();
    }

    /** @test */
    public function a_user_can_visit_the_download_group_list_page()
    {
        $response = $this->get(route('hu.download.categories.index'));

        $response->assertOk();

        $response->assertViewIs('pages.download.categories.index');
    }

    /** @test */
    public function a_user_can_visit_a_download_group_page()
    {
        $downloadCategory = DownloadCategory::factory()->withTranses()->create();

        $response = $this->get(route('hu.download.categories.show', $downloadCategory->translation->slug));

        $response->assertOk();

        $response->assertSeeText('Letöltések -');
    }
}
