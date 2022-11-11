<?php

namespace Tests\Unit\Repositories;

use App\Models\Card;
use App\Repositories\CardRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CardRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function the_home_page_query_returns_a_collection()
    {
        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertInstanceOf(Collection::class, $results);
    }

    /** @test */
    public function the_home_page_query_only_queries_the_active_cards()
    {
        Card::factory()->create();
        Card::factory()->create();
        Card::factory()->inactive()->create();
        Card::factory()->inactive()->create();
        Card::factory()->inactive()->create();

        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertCount(2, $results);
        $this->assertSame(1, $results->first()->active);
    }

    /** @test */
    public function the_home_page_query_only_returns_the_cards_valid_today()
    {
        Card::factory()->create([
            'valid_start' => today()->sub('5 days'),
            'valid_end' => today()->sub('3 days'),
        ]);
        $valid = Card::factory()->create([
            'valid_start' => today()->sub('1 day'),
            'valid_end' => today()->add('1 day'),
        ]);
        Card::factory()->create([
            'valid_start' => today()->sub('2 days'),
            'valid_end' => today()->add('2 days'),
        ]);
        Card::factory()->create([
            'valid_start' => today()->sub('1 days'),
            'valid_end' => today()->add('3 days'),
        ]);
        Card::factory()->create([
            'valid_start' => today()->add('3 days'),
            'valid_end' => today()->add('5 days'),
        ]);

        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertCount(3, $results);
        $this->assertNotNull($results->where('id', $valid->id));
    }

    /** @test */
    public function the_home_page_query_orders_the_cards()
    {
        $third = Card::factory()->create([
            'sort' => 3,
        ]);
        $first = Card::factory()->create([
            'sort' => 1,
        ]);
        $second = Card::factory()->create([
            'sort' => 2,
        ]);

        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertSame($first->id, $results[0]->id);
        $this->assertSame($second->id, $results[1]->id);
        $this->assertSame($third->id, $results[2]->id);
    }

    /** @test */
    public function the_home_page_query_returns_cards_that_has_start_date_equal_today()
    {
        Card::factory()->create([
            'valid_start' => today()->sub('5 days'),
            'valid_end' => today()->add('3 days'),
        ]);
        $valid = Card::factory()->create([
            'valid_start' => today(),
            'valid_end' => today()->add('1 day'),
        ]);
        Card::factory()->create([
            'valid_start' => today()->sub('2 days'),
            'valid_end' => today()->add('2 days'),
        ]);

        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertCount(3, $results);
        $this->assertNotNull($results->where('id', $valid->id));
    }

    /** @test */
    public function the_home_page_query_returns_cards_that_has_end_date_equal_today()
    {
        Card::factory()->create([
            'valid_start' => today()->sub('5 days'),
            'valid_end' => today()->add('3 days'),
        ]);
        $valid = Card::factory()->create([
            'valid_start' => today()->sub('3 days'),
            'valid_end' => today(),
        ]);
        Card::factory()->create([
            'valid_start' => today()->sub('2 days'),
            'valid_end' => today()->add('2 days'),
        ]);

        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertCount(3, $results);
        $this->assertNotNull($results->where('id', $valid->id));
    }

    /** @test */
    public function the_home_page_query_returns_the_cards_without_start_date()
    {
        Card::factory()->create([
            'valid_start' => null,
            'valid_end' => today()->add('3 days'),
        ]);
        Card::factory()->create([
            'valid_start' => null,
            'valid_end' => today(),
        ]);
        Card::factory()->create([
            'valid_start' => null,
            'valid_end' => today()->add('2 days'),
        ]);

        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertCount(3, $results);
    }

    /** @test */
    public function the_home_page_query_returns_the_cards_without_end_date()
    {
        Card::factory()->create([
            'valid_start' => today()->sub('5 days'),
            'valid_end' => null,
        ]);
        Card::factory()->create([
            'valid_start' => today()->sub('3 days'),
            'valid_end' => null,
        ]);
        Card::factory()->create([
            'valid_start' => today()->sub('2 days'),
            'valid_end' => null,
        ]);

        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertCount(3, $results);
    }

    /** @test */
    public function the_home_page_query_returns_the_cards_with_no_dates()
    {
        Card::factory()->create([
            'valid_start' => null,
            'valid_end' => null,
        ]);
        Card::factory()->create([
            'valid_start' => null,
            'valid_end' => null,
        ]);
        Card::factory()->create([
            'valid_start' => null,
            'valid_end' => null,
        ]);

        $repo = new CardRepository();

        $results = $repo->homePageCards();

        $this->assertCount(3, $results);
    }
}
