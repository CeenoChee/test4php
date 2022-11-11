<?php

namespace App\Providers;

use App\Http\ViewComposer\FooterComposer;
use App\Http\ViewComposer\MainMenuComposer;
use App\Http\ViewComposer\SiteMessageComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        View::composer('layouts.includes.main-menu', MainMenuComposer::class);
        View::composer('layouts.includes.footer', FooterComposer::class);
        View::composer('layouts.app', SiteMessageComposer::class);
    }
}
