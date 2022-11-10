<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Download;
use App\Models\DownloadCategory;
use App\Models\Media;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DownloadTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function has_many_transes()
    {
        $download = Download::factory()->withTranses()->create();

        $this->assertEquals(2, $download->transes()->get()->count());
    }

    /** @test */
    public function has_a_category()
    {
        $download = Download::factory()->withCategories()->create();

        $this->assertTrue(is_a($download->categories()->first(), DownloadCategory::class));
    }

    /** @test */
    public function is_able_to_get_the_attached_file()
    {
        $download = Download::factory()->withMedia()->create();

        $this->assertTrue(is_a($download->getDownload(), Media::class));
    }

    /** @test */
    public function is_able_to_get_the_attached_icon()
    {
        $download = Download::factory()->withMedia()->create();

        $this->assertTrue(is_a($download->getIcon(), Media::class));
    }
}
