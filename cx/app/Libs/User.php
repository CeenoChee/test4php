<?php

namespace App\Libs;

use Illuminate\Support\Facades\Auth;

class User extends UserInfo
{
    private bool $isLoggedIn;

    public function __construct()
    {
        $this->isLoggedIn = Auth::check();

        if ($this->isLoggedIn) {
            parent::__construct(Auth::user());
        } else {
            parent::__construct(null);
        }
    }

    public function isLoggedIn(): bool
    {
        return $this->isLoggedIn;
    }
}
