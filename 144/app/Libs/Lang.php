<?php

namespace App\Libs;

use App\Models\Language;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class Lang
{
    protected $languages = [];
    protected $urls = [];

    public function __construct()
    {
        foreach (Language::whereIn('KodAlpha2', $this->getHasznalhato())->get() as $language) {
            $this->languages[$language->KodAlpha2] = $language;
        }
    }

    public function getDefaultLocale()
    {
        return config('app.locale');
    }

    public function getHasznalhato(): array
    {
        return ['hu', 'en'];
    }

    public function setLocale($locale)
    {
        if (! $this->isLocale($locale)) {
            $locale = $this->getDefaultLocale();
        }

        App::setLocale($locale);

        URL::defaults([
            'locale' => $locale,
        ]);
    }

    public function getLocale()
    {
        return App::getLocale();
    }

    public function getLocales()
    {
        return array_keys($this->languages);
    }

    public function getLanguages()
    {
        return $this->languages;
    }

    public function isLocale($locale)
    {
        return array_key_exists($locale, $this->languages);
    }

    public function getLanguage($locale = null)
    {
        $locale = ($locale === null ? $this->getLocale() : $locale);

        return $this->isLocale($locale) ? $this->languages[$locale] : null;
    }

    public function getLanguageById($languageID)
    {
        foreach ($this->languages as $language) {
            if ($language->Nyelv_ID == $languageID) {
                return $language;
            }
        }

        return null;
    }

    public function getLocalById($languageID)
    {
        $language = $this->getLanguageById($languageID);
        if ($language) {
            return $language->KodAlpha2;
        }

        return null;
    }

    public function getLanguageId($locale = null): int
    {
        if ($language = $this->getLanguage($locale)) {
            return $language->Nyelv_ID;
        }

        return Language::HU;
    }

    public function getProductURLPrefix($locale = null)
    {
        $locale = $locale === null ? $this->getLocale() : $locale;
        $productSlugPrefix = config('riel.product_slug_prefix', []);

        if (array_key_exists($locale, $productSlugPrefix)) {
            return $productSlugPrefix[$locale];
        }

        if (array_key_exists('en', $productSlugPrefix)) {
            return $productSlugPrefix['en'];
        }

        return 'products';
    }

    public function getUrl($locale)
    {
        $currentRoute = \Illuminate\Support\Facades\Route::current();
        if (! $currentRoute) {
            return LUrl::route('home');
        }

        $routeName = \Illuminate\Support\Facades\Route::currentRouteName();
        if (in_array(substr($routeName, 0, 2), $this->getLocales()) && substr($routeName, 2, 1) == '.') {
            // Ha route neve <local>. al kezdődik akkor azt le kell vágni róla.
            $route = LUrl::route(substr($routeName, 3), $currentRoute->parameters(), false, $locale);
        } else {
            $route = route($routeName, array_merge($currentRoute->parameters(), ['locale' => $locale]), false);
        }

        return array_key_exists($locale, $this->urls) ? $this->urls[$locale] : $route;
    }

    public function setUrl($locale, $url)
    {
        $this->urls[$locale] = $url;
    }

    public function view($view = null, $data = [], $mergeData = []): \Illuminate\Contracts\View\View
    {
        $langView = $view . '_' . $this->getLocale();
        if (! View::exists($langView)) {
            $langView = $view . '_hu';
        }

        return view($langView, $data, $mergeData);
    }
}
