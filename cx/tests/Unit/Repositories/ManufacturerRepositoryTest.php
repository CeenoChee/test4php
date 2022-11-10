<?php

namespace Tests\Unit\Repositories;

use App\Models\Manufacturer;
use App\Repositories\ManufacturerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ManufacturerRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function the_home_page_query_returns_a_collection()
    {
        $repo = new ManufacturerRepository();

        $results = $repo->homePageManufacturers();

        $this->assertInstanceOf(Collection::class, $results);
    }

    /** @test */
    public function the_home_page_query_only_queries_the_active_manufacturers()
    {
        Manufacturer::factory()->create();
        Manufacturer::factory()->create();
        Manufacturer::factory()->inactive()->create();
        Manufacturer::factory()->inactive()->create();
        Manufacturer::factory()->inactive()->create();

        $repo = new ManufacturerRepository();

        $results = $repo->homePageManufacturers();

        $this->assertCount(2, $results);
        $this->assertSame(1, $results->first()->active);
    }

    /** @test */
    public function the_home_page_query_orders_the_manufacturers()
    {
        $third = Manufacturer::factory()->create([
            'sort' => 3,
        ]);
        $first = Manufacturer::factory()->create([
            'sort' => 1,
        ]);
        $second = Manufacturer::factory()->create([
            'sort' => 2,
        ]);

        $repo = new ManufacturerRepository();

        $results = $repo->homePageManufacturers();

        $this->assertSame(1, $results[0]->sort);
        $this->assertSame(2, $results[1]->sort);
        $this->assertSame(3, $results[2]->sort);
    }

    /** @test */
    public function the_warranty_page_query_only_returns_the_warranty_active_manufacturers()
    {
        Manufacturer::factory()->create();
        Manufacturer::factory()->create();
        Manufacturer::factory()->warrantyInActive()->create();
        Manufacturer::factory()->warrantyInActive()->create();
        Manufacturer::factory()->warrantyInActive()->create();

        $repo = new ManufacturerRepository();

        $results = $repo->warrantyPageManufacturers();

        $this->assertCount(2, $results);
        $this->assertSame(1, $results->first()->active);
    }
}
