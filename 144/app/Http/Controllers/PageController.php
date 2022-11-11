<?php

namespace App\Http\Controllers;

use App\Repositories\ManufacturerRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    public function career()
    {
        return view('pages.career');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function repair()
    {
        return view('pages.repair');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function warranty(ManufacturerRepository $manufacturerRepo)
    {
        return view('pages.warranty', [
            'manufacturers' => $manufacturerRepo->warrantyPageManufacturers(),
        ]);
    }

    public function divisions()
    {
        return view('pages.divisions');
    }

    public function closeSiteMessage()
    {
        if (! Cookie::has('closed-site-message')) {
            $response = new Response();
            $response->withCookie(cookie('closed-site-message', 'true', 1440)); // 24 óra

            return $response;
        }
    }
}
