<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VideoCategoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function has_many_videos()
    {
        $category = VideoCategory::factory()->withVideos()->create();

        $this->assertInstanceOf(Video::class, $category->videos->first());
    }

}
