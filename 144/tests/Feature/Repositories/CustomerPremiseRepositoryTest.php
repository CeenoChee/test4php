<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Agent;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerPremise;
use App\Repositories\CustomerPremiseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerPremiseRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected CustomerPremiseRepository $repo;

    public function setup(): void
    {
        parent::setUp();

        $this->repo = new CustomerPremiseRepository();
    }

    /** @test */
    public function it_is_able_to_store_customer_premise()
    {
        $customer = Customer::factory()->create();

        $lastId = CustomerPremise::where('Ugyfel_ID', $customer->Ugyfel_ID)
            ->orderByDesc('UgyfelTelephely_ID')
            ->pluck('UgyfelTelephely_ID')
            ->first();

        $request = [
            'Ugyfel_ID' => $customer->Ugyfel_ID,
            'UgyfelTelephely_ID' => $lastId ? $lastId + 1 : 1,
            'Kod' => 1,
            'Nev' => $this->faker->name,
            'Orszag_ID' => Country::factory()->create()->Orszag_ID,
            'Helyseg' => $this->faker->city,
            'UtcaHSzam' => $this->faker->streetAddress,
            'IrSzam' => $this->faker->postcode,
            'Ugynok_ID' => Agent::factory()->create()->Ugynok_ID,
        ];

        $this->repo->create($request);

        $this->assertDatabaseHas((new CustomerPremise())->getTable(), [
            'Nev' => $request['Nev'],
        ]);
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
