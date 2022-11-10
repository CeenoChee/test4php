<?php

namespace App\Http\Middleware;

use App\Libs\User;

class HasOrderPermission extends BasePermissionMiddleware
{
    public function hasPermission(User $user)
    {
        return $user->hasOrderPermission();
    }
}
