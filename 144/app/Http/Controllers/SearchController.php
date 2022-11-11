<?php

namespace App\Http\Controllers;

use App\Libs\LUrl;
use App\Libs\Price;
use App\Models\Download;
use App\Models\Knowledge;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Repositories\KnowledgeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function data(): array
    {
        $trans = [
            'products' => trans('pages/products.products'),
            'categories' => trans('pages/products.categories'),
            'knowledge' => trans('pages/knowledge.knowledge'),
            'downloads' => trans('pages/downloads.downloads'),
            'sale' => trans('pages/products.sale'),
            'vat' => trans('prices.vat'),
            'project' => trans('pages/projects.project'),
            'news' => trans('pages/products.news'),
            'discounted_price' => trans('prices.discounted_price'),
            'show_all' => trans('global.show_all'),
            'more_products' => trans('pages/products.more_products'),
            'no_price' => trans('prices.no_price'),
            'additional_products' => trans('pages/products.additional_products'),
            'substitute' => trans('pages/products.substitute'),
        ];

        return [
            'trans' => $trans,
            'urls' => [
                'knowledge' => LUrl::route('knowledge.index'),
                'download' => LUrl::route('download.categories.index'),
            ],
            'categories' => $this->getCategories(),
            'knowledge' => $this->getKnowledges(),
            'downloads' => $this->getDownloads(),
            'products' => $this->getProducts(),
        ];
    }

    public function category(Request $request)
    {
        $productCategory = ProductCategory::findOrFail($request->TermekfaLevel_ID);

        return redirect(LUrl::routeCategory($productCategory));
    }

    public function knowledge(Request $request)
    {
        $knowledge = Knowledge::findOrFail($request->Tudastar_ID);

        return redirect(LUrl::routeKnowledge($knowledge));
    }

    public function product(Request $request)
    {
        $product = Product::findOrFail($request->Termek_ID);

        return redirect(LUrl::routeProduct($product));
    }

    public function download(Request $request)
    {
        $download = Download::findOrFail($request->Letoltes_ID);

        return redirect(LUrl::route('download.show', ['download' => $download->id]));
    }

    public function allProduct(Request $request)
    {
        return redirect(LUrl::routeCategory(null, ['kulcsszo' => $request->keyword]));
    }

    private function getProducts(): array
    {
        $user = app('User');
        $languageID = app('Lang')->getLanguageId();

        $blacklistedManufacturerIds = (new Manufacturer())->getBlacklistedIds();

        if ($user->isRielActive()) {
            $sql = "
				SELECT
					t.Termek_ID,
					t.Kod,
					ifnull(tf.Nev, t.Nev) AS Nev,
					gy.Nev AS Gyarto,
					ifnull(tk.file_name, '') AS Kep,
					tua.UgyfelAr AS Ar,
					t.Projekt AS Projekt,
					t.Ujdonsag AS Ujdonsag,
                    hlt.HelyettesitoTermek_Kodok,
				    kieg.KiegeszitoTermek_IDS,
				    CASE WHEN ta.AkciosAr IS NULL THEN 0 ELSE 1 END AS Akcios,
                    CASE WHEN ta.AkcioNev IS NULL THEN '' ELSE ta.AkcioNev END AS AkcioNev
				FROM termek t
				LEFT JOIN termek_forditas tf ON tf.Termek_ID = t.Termek_ID AND tf.Nyelv_ID = ?
				INNER JOIN manufacturers gy ON t.Gyarto_ID = gy.Gyarto_ID
				LEFT JOIN (SELECT th.HelyettesitoTermek_ID AS Termek_ID ,GROUP_CONCAT(t2.Kod) HelyettesitoTermek_Kodok from termek_helyettesitotermek th LEFT JOIN termek t2 ON t2.Termek_ID = th.Termek_ID
                GROUP BY th.HelyettesitoTermek_ID) AS hlt ON hlt.Termek_ID = t.Termek_ID
                LEFT JOIN (SELECT tk4.Termek_ID AS Termek_ID, GROUP_CONCAT(tk4.KiegeszitoTermek_ID) AS KiegeszitoTermek_IDS FROM termek_kiegeszitotermek tk4 GROUP BY tk4.Termek_ID) AS kieg ON kieg.Termek_ID = t.Termek_ID
                LEFT JOIN (
                    SELECT * FROM (
                        SELECT
                            DENSE_RANK() OVER (PARTITION BY mm.model_id ORDER BY mm.sort ASC) row_id,
                            mm.model_id,
                            mm.media_id
                        FROM media_model mm
                        INNER JOIN media m on m.id = mm.media_id AND m.collection_name = 'image'
                        WHERE mm.model_type = 'Termek'
                    ) mm
                    WHERE mm.row_id = 1
                ) mm ON mm.model_id = t.Termek_ID
                LEFT JOIN media tk ON tk.id = mm.media_id
				LEFT JOIN view_termek_ar ta ON ta.Termek_ID = t.Termek_ID AND ta.Deviza_ID = ?
				LEFT JOIN view_termek_ugyfel_ar tua ON tua.Termek_ID = t.Termek_ID AND tua.CsopFizetesiFeltetel_ID = ? AND tua.Deviza_ID = ?
				WHERE t.Aktiv = 1 AND t.Lathato = 1
                AND t.Gyarto_ID NOT IN (" . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ')
			';

            $currencyID = $user->getCurrencyID();
            $products = DB::select($sql, [$languageID, $currencyID, $user->getGroupPaymentConditionID(), $currencyID]);
            foreach ($products as $row) {
                if ($row->Ar) {
                    $row->Ar = (string) (new Price($row->Ar, $currencyID));
                }
                $row->Kep = ($row->Kep ? route('file.download.image', ['slug' => $row->Kep, 'size' => 'thumbnail']) : '');
            }

            return $products;
        }

        $sql = "
			SELECT
				t.Termek_ID,
				t.Kod,
				ifnull(tf.Nev, t.Nev) AS Nev,
				gy.Nev AS Gyarto,
				ifnull(tk.file_name, '') AS Kep,
				t.Projekt AS Projekt,
				t.Ujdonsag AS Ujdonsag,
				hlt.HelyettesitoTermek_Kodok,
				kieg.KiegeszitoTermek_IDS
			FROM termek t
			LEFT JOIN termek_forditas tf ON tf.Termek_ID = t.Termek_ID AND tf.Nyelv_ID = 0
			INNER JOIN manufacturers gy ON t.Gyarto_ID = gy.Gyarto_ID
			LEFT JOIN (SELECT th.HelyettesitoTermek_ID AS Termek_ID ,GROUP_CONCAT(t2.Kod) HelyettesitoTermek_Kodok from termek_helyettesitotermek th LEFT JOIN termek t2 ON t2.Termek_ID = th.Termek_ID
            GROUP BY th.HelyettesitoTermek_ID) AS hlt ON hlt.Termek_ID = t.Termek_ID
            LEFT JOIN (SELECT tk4.Termek_ID AS Termek_ID, GROUP_CONCAT(tk4.KiegeszitoTermek_ID) AS KiegeszitoTermek_IDS FROM termek_kiegeszitotermek tk4 GROUP BY tk4.Termek_ID) AS kieg ON kieg.Termek_ID = t.Termek_ID
            LEFT JOIN (
                SELECT * FROM (
                        SELECT
                            DENSE_RANK() OVER (PARTITION BY mm.model_id ORDER BY mm.sort ASC) row_id,
                            mm.model_id,
                            mm.media_id
                        FROM media_model mm
                        INNER JOIN media m on m.id = mm.media_id AND m.collection_name = 'image'
                        WHERE mm.model_type = 'Termek'
                ) mm
                WHERE mm.row_id = 1
            ) mm ON mm.model_id = t.Termek_ID
            LEFT JOIN media tk ON tk.id = mm.media_id
			WHERE t.Aktiv = 1 AND t.Lathato = 1
            AND t.Gyarto_ID NOT IN (" . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ');
		';

        $products = DB::select($sql, [$languageID]);

        foreach ($products as $row) {
            $row->Kep = ($row->Kep ? route('file.download.image', ['slug' => $row->Kep, 'size' => 'thumbnail']) : '');
        }

        return $products;
    }

    private function getCategories(): array
    {
        $categories = [];
        $categoryManager = app('Category');
        foreach ($categoryManager->all() as $category) {
            $categories[] = [
                'id' => $category->TermekfaLevel_ID,
                'path' => $categoryManager->getFullName($category->TermekfaLevel_ID),
            ];
        }

        return $categories;
    }

    private function getDownloads(): array
    {
        $downloads = [];

        foreach (Download::with('transes')->get() as $download) {
            if (! $download->trans()) {
                continue;
            }

            $downloads[] = [
                'id' => $download->id,
                'name' => $download->trans()->name,
                'version' => $download->version,
            ];
        }

        return $downloads;
    }

    private function getKnowledges(): array
    {
        $knowledges = [];
        foreach ((new KnowledgeRepository())->getActive() as $knowledge) {
            $knowledges[] = [
                'id' => $knowledge->id,
                'title' => $knowledge->translation->title,
            ];
        }

        return $knowledges;
    }
}
