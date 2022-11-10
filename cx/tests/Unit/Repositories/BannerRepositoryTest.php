<?php

namespace Tests\Unit\Repositories;

use App\Models\Banner;
use App\Repositories\BannerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

class BannerRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function the_home_page_query_only_returns_one_from_the_banners()
    {
        Banner::factory()->create();
        Banner::factory()->create();
        Banner::factory()->create();
        Banner::factory()->create();
        Banner::factory()->create();

        $repo = new BannerRepository();

        $result = $repo->homePageBanner();

        $this->assertInstanceOf(Banner::class, $result);
        $this->assertNotInstanceOf(Collection::class, $result);
    }

    /** @test */
    public function the_home_page_query_only_queries_the_active_banners_for_the_home_page()
    {
        $activeBanner = Banner::factory()->create();
        $inactiveBanner = Banner::factory()->inactive()->create();

        $repo = new BannerRepository();

        $result = $repo->homePageBanner();

        $this->assertSame(1, $result->active);
    }

    /** @test */
    public function the_home_page_query_only_returns_a_banner_valid_today()
    {
        Banner::factory()->create([
            'valid_start' => today()->sub('5 days'),
            'valid_end' => today()->sub('3 days'),
        ]);
        $valid = Banner::factory()->create([
            'valid_start' => today()->sub('1 day'),
            'valid_end' => today()->add('1 day'),
        ]);
        Banner::factory()->create([
            'valid_start' => today()->add('3 days'),
            'valid_end' => today()->add('5 days'),
        ]);

        $repo = new BannerRepository();

        $result = $repo->homePageBanner();

        $this->assertSame($valid->id, $result->id);
    }

    /** @test */
    public function the_home_page_query_returns_a_banner_if_its_start_date_equal_with_today()
    {
        $valid = Banner::factory()->create([
            'valid_start' => today(),
            'valid_end' => today()->add('1 day'),
        ]);

        $repo = new BannerRepository();

        $result = $repo->homePageBanner();

        $this->assertSame($valid->id, $result->id);
    }

    /** @test */
    public function the_home_page_query_returns_a_banner_if_its_end_date_equal_with_today()
    {
        $valid = Banner::factory()->create([
            'valid_start' => today()->sub('3 days'),
            'valid_end' => today(),
        ]);

        $repo = new BannerRepository();

        $result = $repo->homePageBanner();

        $this->assertSame($valid->id, $result->id);
    }

    /** @test */
    public function the_home_page_query_returns_the_banner_without_start_date()
    {
        $banner = Banner::factory()->create([
            'valid_start' => null,
            'valid_end' => today()->add('3 days'),
        ]);

        $repo = new BannerRepository();

        $result = $repo->homePageBanner();

        $this->assertInstanceOf(Banner::class, $result);
        $this->assertSame($banner->id, $result->id);
    }

    /** @test */
    public function the_home_page_query_returns_the_banner_without_end_date()
    {
        $banner = Banner::factory()->create([
            'valid_start' => today()->sub('5 days'),
            'valid_end' => null,
        ]);

        $repo = new BannerRepository();

        $result = $repo->homePageBanner();

        $this->assertInstanceOf(Banner::class, $result);
        $this->assertSame($banner->id, $result->id);
    }

    /** @test */
    public function the_home_page_query_returns_the_banner_without_dates()
    {
        $banner = Banner::factory()->create([
            'valid_start' => null,
            'valid_end' => null,
        ]);

        $repo = new BannerRepository();

        $result = $repo->homePageBanner();

        $this->assertInstanceOf(Banner::class, $result);
        $this->assertSame($banner->id, $result->id);
    }
}
