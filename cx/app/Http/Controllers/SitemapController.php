<?php

namespace App\Http\Controllers;

use App\Libs\LUrl;
use App\Libs\Sitemap\SitemapIndex;
use App\Libs\Sitemap\UrlSet;
use App\Models\Download;
use App\Models\DownloadCategory;
use App\Models\Product;
use App\Models\ProductCategory;

class SitemapController extends Controller
{
    private $locales;

    private array $types = [
        'pages',
        'productCategory',
        'product',
        'download',
    ];

    public function __construct()
    {
        $this->locales = app('Lang')->getLocales();
    }

    public function index()
    {
        $sitemap = new SitemapIndex();

        foreach ($this->locales as $locale) {
            foreach ($this->types as $type) {
                $sitemap->addSitemap(route('sitemap.type', ['locale' => $locale, 'type' => $type]));
            }
        }
        $sitemap->download();
    }

    public function type($locale, $type)
    {
        if (! in_array($type, $this->types)) {
            abort(404);
        }

        if (! in_array($locale, $this->locales)) {
            abort(404);
        }

        $sitemap = new UrlSet();

        $this->{$type}($sitemap, $locale);
        $sitemap->download();
    }

    private function pages(UrlSet $sitemap, $currentLocale)
    {
        $names = [
            'home' => [
                'changefreq' => 'daily',
                'priority' => 1,
            ],
            'academy' => [
                'changefreq' => 'monthly',
                'priority' => 0.5,
            ],
            'contact' => [
                'changefreq' => 'monthly',
                'priority' => 1,
            ],
            'career' => [
                'changefreq' => 'weekly',
                'priority' => 0.2,
            ],
            'support' => [
                'changefreq' => 'weekly',
                'priority' => 0.8,
            ],
            'support.results' => [
                'changefreq' => 'weekly',
                'priority' => 0.8,
            ],
            'ticket' => [
                'changefreq' => 'yearly',
                'priority' => 0.2,
            ],
            'videos.index' => [
                'changefreq' => 'weekly',
                'priority' => 0.5,
            ],
            'faq' => [
                'changefreq' => 'monthly',
                'priority' => 0.1,
            ],
            'warranty' => [
                'changefreq' => 'monthly',
                'priority' => 0.5,
            ],
            'repair' => [
                'changefreq' => 'monthly',
                'priority' => 0.5,
            ],
        ];

        foreach ($names as $name => $property) {
            $alternate = [];
            foreach ($this->locales as $locale) {
                if ($locale !== $currentLocale) {
                    $alternate[$locale] = LUrl::route($name, [], true, $locale);
                }
            }
            $sitemap->add(LUrl::route($name, [], true, $currentLocale), $property['priority'], null, $property['changefreq'], $alternate);
        }
    }

    private function productCategory(UrlSet $sitemap, $currentLocale)
    {
        // Fő termékkategória
        $alternate = [];
        foreach ($this->locales as $locale) {
            if ($locale !== $currentLocale) {
                $alternate[$locale] = LUrl::routeCategory(null, [], $locale, true);
            }
        }
        $sitemap->add(LUrl::routeCategory(null, [], $currentLocale, true), 1, null, 'hourly', $alternate);

        // Termékkkategóriák
        foreach (ProductCategory::from('termekfa_level as tl')->with('trans')->whereDoesntHaveBlacklistedProduct('tl')->get() as $productCategory) {
            $alternate = [];
            foreach ($this->locales as $locale) {
                if ($locale !== $currentLocale) {
                    $alternate[$locale] = LUrl::routeCategory($productCategory, [], $locale, true);
                }
            }
            $sitemap->add(LUrl::routeCategory($productCategory, [], $currentLocale, true), 1, date('Y-m-d', strtotime($productCategory->ModDatum)), 'hourly', $alternate);
        }
    }

    private function product(UrlSet $sitemap, $currentLocale)
    {
        $products = Product::active()->with('manufacturer');

        $products->visibleForCustomer();

        foreach ($products->get() as $product) {
            $alternate = [];
            foreach ($this->locales as $locale) {
                if ($locale !== $currentLocale) {
                    $alternate[$locale] = LUrl::routeProduct($product, true, $locale);
                }
            }
            $sitemap->add(LUrl::routeProduct($product, true, $currentLocale), 1, date('Y-m-d', strtotime($product->ModDatum)), 'daily', $alternate);
        }
    }

    private function download(UrlSet $sitemap, $currentLocale)
    {
        $alternate = [];
        foreach ($this->locales as $locale) {
            if ($locale !== $currentLocale) {
                $alternate[$locale] = LUrl::route('download.categories.index', [], true, $locale);
            }
        }
        $sitemap->add(LUrl::route('download.categories.index', [], true, $currentLocale), 0.8, null, 'weekly', $alternate);

        foreach (DownloadCategory::with('transes')->get() as $downloadCategory) {
            $alternate = [];
            foreach ($this->locales as $locale) {
                if ($locale !== $currentLocale) {
                    $alternate[$locale] = LUrl::routeDownloadCategory($downloadCategory, [], $locale, true);
                }
            }
            $sitemap->add(LUrl::routeDownloadCategory($downloadCategory, [], $currentLocale, true), 0.8, date('Y-m-d', strtotime($downloadCategory->updated_at)), 'weekly', $alternate);
        }

        foreach (Download::with('transes')->get() as $download) {
            $alternate = [];
            foreach ($this->locales as $locale) {
                if ($locale !== $currentLocale) {
                    $alternate[$locale] = LUrl::route('download.show', ['download' => $download->id], true, $locale);
                }
            }
            $sitemap->add(LUrl::route('download.show', ['download' => $download->id], true, $currentLocale), 0.8, date('Y-m-d', strtotime($download->updated_at)), 'weekly', $alternate);
        }
    }
}
