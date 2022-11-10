<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\DownloadCategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DownloadCategoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function has_many_transes()
    {
        $downloadCategory = DownloadCategory::factory()->withTranses()->create();

        $this->assertEquals(2, $downloadCategory->translations()->count());
    }

    /** @test */
    public function has_many_downloads()
    {
        $downloadCategory = DownloadCategory::factory()->withDownloads()->create();

        $this->assertEquals(1, $downloadCategory->downloads()->count());
    }
}
