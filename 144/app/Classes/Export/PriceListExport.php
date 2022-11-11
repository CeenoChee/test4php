<?php

declare(strict_types=1);

namespace App\Classes\Export;

use App\Classes\Export\Sheets\ProductCategorySheet;
use App\Libs\User;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PriceListExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->getProducts() as $sheetName => $dataItem) {
            $sheets[] = new ProductCategorySheet($sheetName, $dataItem);
        }

        return $sheets;
    }

    public function getProducts(): array
    {
        $user = app('User');
        $category = app('Category');
        $isRiel = app('User')->isRiel();

        $rows = DB::select($this->getQuery($user), [
            $user->getCurrencyID(),
            $user->getCurrencyID(),
            $user->getGroupPaymentConditionID(),
        ]);

        $data = [];

        foreach ($rows as $row) {
            $path = $category->getPath($row->TermekfaLevel_ID);

            if (! isset($path[0])) {
                continue;
            }

            $categoryName = $path[0]->Nev;

            $product = [
                trans('pages/products.manufacture') => $row->Gyarto,
                trans('pages/products.model_no') => $row->Kod,
                trans('form.description') => $row->Nev,
                trans('prices.list_price') => $row->ListaAr,
                trans('prices.sale_price') => $row->AkciosAr,
                trans('prices.discounted_price') => $row->UgyfelAr,
            ];

            if ($isRiel) {
                $product[trans('stocks.hu_stock')] = $row->HuKeszlet ?? '';
                $product[trans('stocks.eu_stock')] = $row->EuKeszlet ?? '';
            } else {
                if (isset($row->HuKeszlet)) {
                    $stock = $row->HuKeszlet > 20 ? '20+' : $row->HuKeszlet;
                } else {
                    $stock = '';
                }

                $product[trans('stocks.hu_stock')] = $stock;
            }

            $data[$categoryName][] = array_merge($product, [
                trans('pages/products.sale') => $row->AkciosAr ? 'A' : '',
                trans('pages/products.project') => $row->Projekt ? 'P' : '',
                trans('pages/products.it_product') => $row->ItTermek ? 'IT' : '',
                trans('pages/products.category') . ' 1' => $path[0]->Nev,
                trans('pages/products.category') . ' 2' => isset($path[1]) ? $path[1]->Nev : '',
                trans('pages/products.category') . ' 3' => isset($path[2]) ? $path[2]->Nev : '',
            ]);
        }

        return $data;
    }

    private function getQuery(User $user): string
    {
        $blacklistedManufacturerIds = (new Manufacturer())->getBlacklistedIds($user->getCustomerId());

        return "
				SELECT
					tfl.TermekfaLevel_ID AS TermekfaLevel_ID,
					ifnull(gy.Nev, '') AS Gyarto,
					t.Kod AS Kod,
					t.Nev AS Nev,
					ta.ListaAr AS ListaAr,
					ta.AkciosAr AS AkciosAr,
					tua.UgyfelAr AS UgyfelAr,
					t.Projekt AS Projekt,
					t.ItTermek AS ItTermek,
					IFNULL(k_hu.SzabadMennyiseg, 0) AS HuKeszlet,
				    IFNULL(k_eu.SzabadMennyiseg, 0) AS EuKeszlet
				FROM termek_termekfa ttf
				INNER JOIN termekfa_level tfl ON tfl.TermekfaLevel_ID = ttf.TermekfaLevel_ID
				INNER JOIN termek t ON t.Termek_ID = ttf.Termek_ID
				LEFT JOIN manufacturers gy ON gy.Gyarto_ID = t.Gyarto_ID
				INNER JOIN view_termek_ar ta ON ta.Termek_ID = t.Termek_ID AND ta.Deviza_ID = ?
				INNER JOIN view_termek_ugyfel_ar tua ON tua.Termek_ID = t.Termek_ID AND tua.Deviza_ID = ? AND tua.CsopFizetesiFeltetel_ID = ?
				LEFT JOIN (
					SELECT k.Termek_ID, sum(k.SzabadMennyiseg) AS SzabadMennyiseg FROM keszlet k
					INNER JOIN raktar r ON r.Raktar_ID = k.Raktar_ID
					WHERE r.Kod IN ('" . implode("','", config('riel.warehouse.inner', [])) . "')
					GROUP BY k.Termek_ID
				) AS k_hu ON k_hu.Termek_ID = t.Termek_ID
				LEFT JOIN (
					SELECT k.Termek_ID, sum(k.SzabadMennyiseg) AS SzabadMennyiseg FROM keszlet k
					INNER JOIN raktar r ON r.Raktar_ID = k.Raktar_ID
					WHERE r.Kod IN ('" . implode("','", config('riel.warehouse.external', [])) . "')
					GROUP BY k.Termek_ID
				) AS k_eu ON k_eu.Termek_ID = t.Termek_ID
				WHERE t.Aktiv = 1 AND t.Lathato = 1
                AND t.Gyarto_ID NOT IN (" . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ')
			';
    }
}
