<?php

namespace Tests\Browser;

use App\Libs\LUrl;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    use WithFaker;

    /** @test */
    public function a_guest_is_able_to_registrate()
    {
        $this->browse(function (Browser $browser) {
            $password = $this->faker->password;
            $browser->visitRoute('hu.register')
                ->type('lastname', $this->faker->word)
                ->type('firstname', $this->faker->word)
                ->type('title', $this->faker->word)
                ->type('mobile', $this->faker->phoneNumber)
                ->select('country', 0)
                ->type('zip', $this->faker->postcode)
                ->type('city', $this->faker->city)
                ->type('address', $this->faker->streetAddress)
                ->type('email', $this->faker->safeEmail)
                ->type('password', $password)
                ->type('password_confirmation', $password)
                ->type('company_name', $this->faker->company)
                ->type('company_tax_number', $this->faker->randomNumber)
                ->type('company_registration_number', $this->faker->randomNumber)
                ->check('aszf')
                ->press('Regisztráció')
                ->assertRouteIs(LUrl::name('register_summary'));
        });
    }

    /** @test */
    public function a_guest_is_unable_to_registrate_without_filling_the_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $password = $this->faker->password;

            $browser->visitRoute('hu.register')
                ->type('firstname', $this->faker->word)
                ->type('title', $this->faker->word)
                ->type('mobile', $this->faker->phoneNumber)
                ->select('country', 0)
                ->type('zip', $this->faker->postcode)
                ->type('city', $this->faker->city)
                ->type('address', $this->faker->streetAddress)
                ->type('email', $this->faker->safeEmail)
                ->type('password', $password)
                ->type('password_confirmation', $password)
                ->type('company_name', $this->faker->company)
                ->type('company_tax_number', $this->faker->randomNumber)
                ->type('company_registration_number', $this->faker->randomNumber)
                ->check('aszf')
                ->press('Regisztráció')
                ->assertRouteIs(LUrl::name('register_summary'));
        });
    }
}
