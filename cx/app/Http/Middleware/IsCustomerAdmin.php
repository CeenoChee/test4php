<?php

namespace App\Http\Middleware;

use App\Libs\LUrl;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class IsCustomerAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = app('User');

        $isLoggedIn = $user->isLoggedIn();
        if ($isLoggedIn && $user->isBanned() === true) {
            Auth::logout();
            $isLoggedIn = false;
        }

        if ($isLoggedIn) {
            if (! $user->isCustomerAdmin()) {
                abort(403);
            }
        } else {
            return redirect()->route(LUrl::name('login'))->with('previous_url', URL::previous());
        }

        return $next($request);
    }
}
