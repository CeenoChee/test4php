<?php

namespace App\Http\Controllers;

use App\Repositories\BannerRepository;
use App\Repositories\CardRepository;
use App\Repositories\ManufacturerRepository;

class HomeController extends Controller
{
    public function __invoke(BannerRepository $bannerRepo, CardRepository $cardRepo, ManufacturerRepository $manufacturerRepo)
    {
        return view('pages.home', [
            'banner' => $bannerRepo->homePageBanner(),
            'cards' => $cardRepo->homePageCards(),
            'manufacturers' => $manufacturerRepo->homePageManufacturers(),
        ]);
    }
}
