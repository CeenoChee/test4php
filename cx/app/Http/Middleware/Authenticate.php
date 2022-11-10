<?php

namespace App\Http\Middleware;

use App\Libs\LUrl;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $user = app('User');
        $isLoggedIn = $user->isLoggedIn();

        if ($isLoggedIn && $user->isBanned()) {
            Auth::logout();
            $isLoggedIn = false;
        }

        if ($isLoggedIn) {
            return $next($request);
        }

        return redirect()
            ->route(LUrl::name('login'))
            ->with(['previous_url', session('_previous.url')]);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
