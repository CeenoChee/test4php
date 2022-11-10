<?php

namespace App\Http\Middleware;

use App\Libs\User;

class IsRielActive extends BasePermissionMiddleware
{
    public function hasPermission(User $user): bool
    {
        return $user->isRielActive();
    }
}
