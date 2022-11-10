<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Libs\UserInfo;
use App\Mail\Register;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * @test
     * @dataProvider requiredFields
     *
     * @param mixed $field
     */
    public function a_guest_is_unable_to_register_without_the_required_fields($field)
    {
        $request = $this->getValidRequest();

        $request[$field] = '';

        $this->post(route('register', 'hu'), $request)
            ->assertSessionHasErrors($field);
    }

    /** @test */
    public function a_guest_is_unable_to_register_if_the_email_is_already_in_use()
    {
        $email = $this->faker->safeEmail;

        User::factory()->create(['email' => $email]);

        $request = $this->getValidRequest();
        $request['email'] = $email;

        $this->post(route('register', 'hu'), $request)
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function is_registration_has_stored_in_database()
    {
        $request = $this->getValidRequest();

        $this->post(route('register', 'hu'), $request);

        $this->assertDatabaseHas((new User())->getTable(), [
            'Keresztnev' => $request['firstname'],
            'Vezeteknev' => $request['lastname'],
            'Beosztas' => $request['title'],
            'Mobil' => $request['mobile'],
            'Orszag_ID' => $request['country'],
            'IrSzam' => $request['zip'],
            'Helyseg' => $request['city'],
            'UtcaHSzam' => $request['address'],
            'email' => $request['email'],
            'Cegnev' => $request['company_name'],
            'Adoszam' => $request['company_tax_number'],
            'Cegjegyzekszam' => $request['company_registration_number'],
        ]);
    }

    /** @test */
    public function the_newly_registered_user_should_not_be_verified()
    {
        $request = $this->getValidRequest();

        $this->post(route('register', 'hu'), $request);

        $user = User::getByEmail($request['email']);

        $this->assertFalse((new UserInfo($user))->isVerified());
    }

    /** @test */
    public function is_newletter_subscription_has_stored_properly_in_database()
    {
        $request = $this->getValidRequest();
        $request['newsletter'] = 1;

        $this->post(route('register', 'hu'), $request);
        $this->assertDatabaseHas((new User())->getTable(), ['newsletter' => 1]);
    }

    /** @test */
    public function is_email_has_been_sent_under_the_registration_process()
    {
        Mail::fake();

        $this->post(route('register', 'hu'), $this->getValidRequest());

        Mail::assertSent(Register::class);
    }

    public function requiredFields(): array
    {
        return [
            ['firstname'],
            ['lastname'],
            ['title'],
            ['mobile'],
            ['country'],
            ['zip'],
            ['city'],
            ['address'],
            ['email'],
            ['password'],
            ['company_name'],
            ['company_registration_number'],
            ['company_tax_number'],
            ['aszf'],
        ];
    }

    private function getValidRequest(): array
    {
        $password = $this->faker->password;

        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'title' => $this->faker->word,
            'mobile' => $this->faker->phoneNumber,

            'country' => $this->faker->randomDigit,
            'zip' => $this->faker->postcode,
            'city' => $this->faker->country,
            'address' => $this->faker->streetAddress,

            'email' => $this->faker->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,

            'company_name' => $this->faker->word,
            'company_registration_number' => $this->faker->randomNumber(7),
            'company_tax_number' => $this->faker->randomNumber(7),
            'aszf' => $this->faker->boolean(100),
        ];
    }
}
