<?php

namespace App\Http\Middleware;

use Closure;

class IsDev
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
        if (! app('User')->isDev()) {
            abort(404);
        }

        return $next($request);
    }
}
