<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VideoControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setup(): void
    {
        parent::setUp();
    }

    /** @test */
    public function a_user_can_visit_the_video_index_page()
    {
        $response = $this->get(route('hu.videos.index'));

        $response->assertOk();

        $response->assertViewIs('pages.videos.index');
    }

    /** @test */
    public function a_user_can_visit_the_video_category_show_page()
    {
        $category = VideoCategory::factory()->withVideos()->create();

        $response = $this->get(route('hu.videos.categories.show', $category->slug));

        $response->assertOk();

        $response->assertViewIs('pages.videos.show');
    }

    /** @test */
    public function a_user_can_search_videos()
    {
        $this->withoutExceptionHandling();
        Video::factory()->create(['title' => 'test']);

        $response = $this->get(route('hu.videos.search') . '?keyword=tes');

        $response->assertOk();

        $response->assertViewIs('pages.videos.results');
    }
}
