<?php

namespace App\Http\Middleware;

use App\Models\Invoice;
use Closure;
use Illuminate\Http\Request;

class CanViewInvoice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()) {
            abort(404);
        }

        $invoice = Invoice::where([
            'Ev' => $request->Ev,
            'Sorozat' => $request->Sorozat,
            'Sorszam' => $request->Sorszam,
        ])->firstOrFail();

        if ($invoice->Ugyfel_ID != $request->user()->getCustomerId()) {
            abort(404);
        }

        return $next($request);
    }
}
