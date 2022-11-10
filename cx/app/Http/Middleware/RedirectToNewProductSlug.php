<?php

namespace App\Http\Middleware;

use App\Libs\LUrl;
use App\Models\Product;
use Closure;
use Illuminate\Http\Request;

class RedirectToNewProductSlug
{
    public function handle(Request $request, Closure $next)
    {
        if (Product::where('RegiEleres', $request->Eleres)
            ->where('Eleres', '!=', $request->Eleres)
            ->exists()) {
            return redirect()->to(LUrl::routeProduct(
                Product::where('RegiEleres', $request->Eleres)
                    ->where('Eleres', '!=', $request->Eleres)
                    ->firstOrFail()
            ), 301);
        }

        return $next($request);
    }
}
