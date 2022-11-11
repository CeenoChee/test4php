<?php

namespace App\Http\Controllers;

use App\Libs\DeliveryTime\ProductSourceHandler;
use App\Libs\Enums\Shipping;
use App\Libs\Fct;
use App\Libs\LUrl;
use App\Libs\ProductAttributeList;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Request $request)
    {
        $product = Product::with('images', 'price.sale')
            ->where('Eleres', $request->Eleres)
            ->visibleForCustomer()
            ->where(function ($query) {
                $query->active()
                    ->orWhere([
                        ['Aktiv', 0],
                        ['Lathato', 1],
                    ]);
            })
            ->firstOrFail();

        $parameters = [
            'GyartoEleres' => Fct::slugify($product->manufacturer->Nev),
            'Eleres' => $product->Eleres,
        ];

        $lang = app('Lang');

        foreach ($lang->getLocales() as $locale) {
            $lang->setUrl($locale, LUrl::route('product.show', $parameters, false, $locale));
        }

        ProductAttributeList::preload($product->Termek_ID);

        $productImages = $product->images()->orderBy('sort')->get();

        return view('pages.products.show', [
            'product' => $product,
            'additionalProducts' => $product->additional()->orderBy('Sorrend')->get(),
            'replacementProducts' => $product->replacement()->orderBy('Sorrend')->get(),
            'relatedProducts' => $product->related()->orderBy('Sorrend')->get(),
            'productImages' => $productImages,
            'images' => json_encode($this->getImageUrls($productImages, 'product-big')),
            'thumbnails' => json_encode($this->getImageUrls($productImages, 'product-small')),
        ]);
    }

    public function deliveryTime(Request $request): array
    {
        $product = Product::findOrFail($request->Termek_ID);

        $qty = (int) $request->mennyiseg;

        if ($qty < 1) {
            $qty = 1;
        }

        return [
            'microtime' => $request->microtime,
            'mennyiseg' => $qty,
            'delivery_time' => view('pages.products.includes.delivery-time', ['product' => $product, 'qty' => $qty])->render(),
        ];
    }

    public function deliveryTimeInfo(Request $request): array
    {
        $product = Product::findOrFail($request->Termek_ID);
        $qty = (int) $request->Mennyiseg;
        if ($qty < 1) {
            $qty = 1;
        }

        $shipping = new Shipping(Shipping::WHOLE);

        $stock = $product->stock->pluck('SzabadMennyiseg', 'Raktar_ID')->toArray();
        $fullStock = 0;
        foreach ($stock as $value) {
            $fullStock += $value;
        }

        $rows = [];
        foreach (Warehouse::inner()->get() as $warehouse) {
            $productSourceHandler = new ProductSourceHandler($shipping, $warehouse);
            $productSourceHandler->addProduct($product->Termek_ID);
            $deliveryTime = $productSourceHandler->getDeliveryTime($product->Termek_ID, $qty);

            $stockQty = $stock[$warehouse->Raktar_ID] ?? 0;

            $color = 'orange';
            if ($stockQty >= $qty) {
                $color = 'green';
            } elseif ($deliveryTime->isEmpty()) {
                $color = 'red';
            }

            $rows[] = [
                'Kod' => $warehouse->Kod,
                'Nev' => $warehouse->Nev,
                'Keszlet' => (! Fct::isRiel() && $stockQty > 20 ? '20+' : $stockQty),
                'SzallHatarido' => $deliveryTime,
                'color' => $color,
            ];
        }

        return [
            'content' => view('pages.products.includes.delivery-time-popup', [
                'product' => $product,
                'rows' => $rows,
                'qty' => $qty,
                'maxOrder' => $product->getStockLimit(),
            ])->render(),
        ];
    }

    private function getImageUrls($images, string $size): array
    {
        $urls = [];

        foreach ($images as $image) {
            $urls[] = $image->getUrl($size);
        }

        return $urls;
    }
}
