<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Customer;
use App\Models\CustomerPremise;
use App\Repositories\CustomerPremiseRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected CustomerPremiseRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new CustomerRepository();
    }

    /** @test */
    public function it_is_able_to_ensure_that_a_customer_is_a_competitor()
    {
        $customer = Customer::factory()->create(['Konkurencia' => 1]);

        $this->assertTrue($this->repo->isCompetitor($customer->Ugyfel_ID));
    }

    /** @test */
    public function it_is_able_to_retrieve_the_highest_ugyfel_telephely_id_by_ugyfel_id()
    {
        $customerPremise = CustomerPremise::factory()->create();

        $this->assertSame(1, $this->repo->getMaxCustomerPremiseIdByCustomerId($customerPremise->Ugyfel_ID));
    }

    /** @test */
    public function it_is_able_to_retrieve_the_highest_integer_casted_kod_by_ugyfel_id()
    {
        $code = 4;
        $customerPremise = CustomerPremise::factory()->create(['Kod' => $code]);

        $this->assertSame($code, $this->repo->getMaxCode($customerPremise->Ugyfel_ID));
    }

    /** @test */
    public function it_is_able_to_retrieve_the_customer_premises_by_ugyfel_id()
    {
        $customerPremise = CustomerPremise::factory()->create();

        $customerPremises = $this->repo->getByCustomerId($customerPremise->Ugyfel_ID);

        $this->assertInstanceOf(CustomerPremise::class, $customerPremises->first());
        $this->assertSame($customerPremise->Nev, $customerPremises->first()->Nev);
    }

    /** @test */
    public function it_is_able_to_retrieve_the_enabled_customer_premises_by_ugyfel_id()
    {
        $enabledCustomerPremise = CustomerPremise::factory()->create();

        $lastId = CustomerPremise::where('Ugyfel_ID', $enabledCustomerPremise->Ugyfel_ID)
            ->orderByDesc('UgyfelTelephely_ID')
            ->pluck('UgyfelTelephely_ID')
            ->first();

        CustomerPremise::factory()->create(
            [
                'Ugyfel_ID' => $enabledCustomerPremise->Ugyfel_ID,
                'UgyfelTelephely_ID' => $lastId ? $lastId + 1 : 1,
                'Hasznalhato' => 0,
            ]
        );

        $enabledCustomerPremises = $this->repo->getEnabledByCustomerId($enabledCustomerPremise->Ugyfel_ID);

        $this->assertCount(1, $enabledCustomerPremises);
        $this->assertInstanceOf(CustomerPremise::class, $enabledCustomerPremises->first());

        $this->assertEquals($enabledCustomerPremise->UgyfelTelephely_ID, $enabledCustomerPremises->first()->UgyfelTelephely_ID);
    }
}
