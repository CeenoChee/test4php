<?php

namespace App\Http\Middleware;

use App\Libs\User;

class HasServicePermission extends BasePermissionMiddleware
{
    public function hasPermission(User $user)
    {
        return $user->hasServicePermission();
    }
}
