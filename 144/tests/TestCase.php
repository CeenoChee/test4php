<?php

namespace Tests;

use App\Models\Serpa\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

//    final protected function signIn(User $user = null)
//    {
//        if (is_null($user)) {
//            $user = (new UserRepository())->firstByUsername(config('database.connections.serpa.username'));
//        }
//
//        $this->actingAs($user);
//
//        return $user;
//    }
}
