<?php

namespace App\Libs;

use App\Models\DownloadCategory;
use App\Models\Knowledge;
use App\Models\Product;
use App\Models\ProductCategory;

class LUrl
{
    public static function name($name, $locale = null)
    {
        return ($locale === null ? app('Lang')->getLocale() : $locale) . '.' . $name;
    }

    public static function route($name, $parameters = [], $absolute = false, $locale = null)
    {
        return app('url')->route(self::name($name, $locale), $parameters, $absolute);
    }

    public static function routeIs(string $routeName)
    {
        return request()->route() && request()->route()->getName() == app('Lang')->getLocale() . '.' . $routeName;
    }

    public static function routeCategory(ProductCategory $productCategory = null, $parameters = [], $locale = null, $absolute = false)
    {
        if ($productCategory === null) {
            return self::route('product.category.main', $parameters, $absolute, $locale);
        }
        $slug = $productCategory->getSlug($locale);
        if ($slug) {
            return self::route('product.category.show', array_merge($parameters, ['Eleres' => $slug]), $absolute, $locale);
        }

        return '';
    }

    public static function routeProduct(Product $product, $absolute = false, $locale = null)
    {
        $parameters = [
            'GyartoEleres' => Fct::slugify($product->manufacturer->Nev),
            'Eleres' => $product->Eleres,
        ];

        return self::route('product.show', $parameters, $absolute, $locale);
    }

    public static function routeKnowledge(Knowledge $knowledge)
    {
        $category = $knowledge->categories->first()->translation;

        $parameters = [
            'categorySlug' => $category ? $category->slug : '-',
            'slug' => $knowledge->translation->slug,
        ];

        return self::route('knowledge.article', $parameters, false, app('Lang')->getLocalById($knowledge->Nyelv_ID));
    }

    public static function routeOrder(Order $order, $absolute = false, $locale = null)
    {
        return self::route('account.order.show', [
            'Ev' => $order->getYear(),
            'Sorozat' => $order->getSerial(),
            'Sorszam' => str_pad($order->getSerialNumber(), 6, '0', STR_PAD_LEFT),
        ], $absolute, $locale);
    }

    public static function routeDownloadCategory(DownloadCategory $downloadCategory, $parameters = [], $locale = null, $absolute = false)
    {
        return LUrl::route('download.categories.show', array_merge($parameters, ['downloadCategorySlug' => $downloadCategory->translate->slug]), $absolute, $locale);
    }
}
