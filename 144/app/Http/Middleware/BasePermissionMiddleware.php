<?php

namespace App\Http\Middleware;

use App\Libs\LUrl;
use App\Libs\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

abstract class BasePermissionMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = app('User');

        $isLoggedIn = $user->isLoggedIn();
        if ($isLoggedIn && $user->isBanned() === true) {
            Auth::logout();
            $isLoggedIn = false;
        }

        if ($isLoggedIn) {
            if (! $this->hasPermission($user)) {
                abort(403);
            }
        } else {
            return redirect()->route(LUrl::name('login'))->with('previous_url', URL::previous());
        }

        return $next($request);
    }

    abstract public function hasPermission(User $user);
}
