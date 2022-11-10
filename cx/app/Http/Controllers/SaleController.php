<?php

namespace App\Http\Controllers;

use App\Repositories\SaleRepository;

class SaleController extends Controller
{
    public function index(SaleRepository $saleRepo)
    {
        return view('pages.sales', ['sales' => $saleRepo->list(['images'])]);
    }
}
