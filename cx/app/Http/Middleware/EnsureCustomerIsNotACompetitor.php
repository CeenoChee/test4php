<?php

namespace App\Http\Middleware;

use App\Libs\LUrl;
use App\Repositories\CustomerRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCustomerIsNotACompetitor
{
    public function handle(Request $request, Closure $next)
    {
        if ((new CustomerRepository())->isCompetitor(Auth::user()->customerEmployee->Ugyfel_ID)) {
            return redirect()->to(LUrl::route('home'));
        }

        return $next($request);
    }
}
