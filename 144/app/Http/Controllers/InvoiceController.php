<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $columns = collect(DB::getSchemaBuilder()->getColumnListing((new Invoice())->getTable()))
            ->filter(fn ($column) => $column !== 'SzamlaPdf')
            ->push(
                DB::raw('CASE WHEN SzamlaPdf IS NULL THEN 0 ELSE 1 END AS SzamlaPdf')
            );

        return view('pages.invoices.index', [
            'invoices' => Invoice::select($columns->toArray())
                ->where('Ugyfel_ID', app('User')->getCustomer()->Ugyfel_ID)
                ->get(),
        ]);
    }

    public function show($Ev, $Sorozat, $Sorszam)
    {
        $invoice = Invoice::where(compact('Ev', 'Sorozat', 'Sorszam'))->firstOrFail();

        return view('pages.invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    public function getPdf($Ev, $Sorozat, $Sorszam)
    {
        $invoice = Invoice::where(compact('Ev', 'Sorozat', 'Sorszam'))->firstOrFail();

        return new \Illuminate\Http\Response($invoice->SzamlaPdf, 200, [
            'content-type' => 'application/pdf',
            'content-disposition' => 'inline; filename="' . $invoice->getNumber() . '"',
            'cache-control' => 'no-cache, private',
        ]);
    }
}
