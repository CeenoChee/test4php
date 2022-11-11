<?php

namespace App\Http\Controllers;

use App\Libs\ProductAttributeList;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ComparisonController extends Controller
{
    public function index()
    {
        $products = Product::whereIn('Termek_ID', Session::get('comparison', []))->extraData()->get();

        foreach ($products as $product) {
            ProductAttributeList::preload($product->Termek_ID);
        }

        $allProperties = [];
        foreach ($products as $product) {
            $productAttributes = $product->getProductAttributes()->get();
            foreach ($productAttributes as $productAttribute) {
                if (! isset($allProperties[$productAttribute->getInnerName()])) {
                    $allProperties[$productAttribute->getInnerName()]['Nev'] = $productAttribute->getName();
                }

                $value = $productAttribute->getValue();

                $allProperties[$productAttribute->getInnerName()]['Ertekek'][$product->Termek_ID] = $value;
            }
        }

        foreach ($allProperties as $slug => $prop) {
            $allProperties[$slug]['repeating'] = count(array_unique($prop['Ertekek'])) <= 1;
        }

        return view('pages.comparison.index', [
            'products' => $products,
            'allProperties' => $allProperties,
        ]);
    }

    public function set(Request $request): array
    {
        $product = Product::visibleForCustomer()->findOrFail($request->Termek_ID);

        $value = ($request->value == 'true');

        $comparison = app('Comparison');
        $comparison->set($product->Termek_ID, $value);

        return [
            'error' => false,
            'microtime' => $request->microtime,
            'value' => $value,
            'count' => $comparison->count(),
            'box_content' => $comparison->renderBoxContent(),
        ];
    }

    public function delete(Request $request): array
    {
        $product = Product::visibleForCustomer()->findOrFail($request->Termek_ID);

        $comparison = app('Comparison');
        $comparison->delete($product->Termek_ID);

        return [
            'error' => false,
            'microtime' => $request->microtime,
            'Termek_ID' => $product->Termek_ID,
            'count' => $comparison->count(),
            'box_content' => $comparison->renderBoxContent(),
        ];
    }

    public function clear(): array
    {
        Session::put('comparison', []);

        return [
            'error' => false,
        ];
    }
}
