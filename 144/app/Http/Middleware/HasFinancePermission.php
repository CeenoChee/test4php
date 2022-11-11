<?php

namespace App\Http\Middleware;

use App\Libs\User;

class HasFinancePermission extends BasePermissionMiddleware
{
    public function hasPermission(User $user)
    {
        return $user->hasFinancePermission();
    }
}
