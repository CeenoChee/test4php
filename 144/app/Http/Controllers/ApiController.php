<?php

namespace App\Http\Controllers;

use App\Libs\Api;
use App\Libs\ArrayToXML;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    public function xml(Request $request)
    {
        $products = $this->getApi($request)->getProductsData();

        $data = [];
        foreach ($products as $product) {
            $data['Product'][] = $product;
        }

        $xml = new ArrayToXML();
        $xml->download($data, 'ProductList');
    }

    public function csv(Request $request)
    {
        switch ($request->delimiter) {
            case 'commas':
                $delimiter = ',';

                break;

            case 'pipes':
                $delimiter = '|';

                break;

            case 'tabs':
                $delimiter = "\t";

                break;

            default:
                $delimiter = ';';

                break;
        }

        $api = $this->getApi($request);

        $products = $api->getProductsData();

        header('Content-Encoding: UTF-8');
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=RIEL_' . date('Ymd_His') . '.csv');

        $f = fopen('php://output', 'w');

        // add BOM to fix UTF-8 in Excel
        fputs($f, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

        $header = [
            'ProductCode',
            'Description',
            'Tags',
            'Manufacturer',
            'ListPrice',
            'PartnerPrice',
            'SalePrice',
            'ProjectProduct',
            'Stock',
            'Image',
            'DataSheet',
            'Category',
            'Accessories',
            'Status',
            'Comment',
        ];

        if ($api->isInstaller()) {
            $header[] = 'InstallerPrice';
        }

        fputcsv($f, $header, $delimiter);

        foreach ($products as $product) {
            fputcsv($f, array_values($product), $delimiter);
        }

        fclose($f);

        exit;
    }

    private function getApi(Request $request): Api
    {
        $apiUrl = parse_url(config('riel.api.host'));

        if ($request->getHost() != $apiUrl['host']) {
            abort(404);
        }

        $api = \App\Models\Api::where('Kulcs', $request->api_key)->first();
        if (! $api) {
            abort(404);
        }

        return new Api($api->customer);
    }
}
