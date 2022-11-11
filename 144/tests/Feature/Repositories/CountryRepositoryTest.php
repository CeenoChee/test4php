<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Country;
use App\Repositories\CountryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected CountryRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new CountryRepository();
    }

    /** @test */
    public function is_able_to_get_countries()
    {
        Country::factory()->create();

        $this->assertCount(1, $this->repo->all());
    }
}
