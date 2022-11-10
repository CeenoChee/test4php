<?php

namespace App\Http\Controllers;

use App\Libs\Fct;
use App\Libs\LUrl;
use App\Libs\Price;
use App\Libs\ProductAttributeList;
use App\Models\Attribute;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryTrans;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function show(Request $request)
    {
        $lang = app('Lang');

        if ($request->Eleres) {
            $productCategoryTrans = ProductCategoryTrans::getBySlug($request->Eleres);
            if (! $productCategoryTrans) {
                abort(404);
            }

            $productCategory = $productCategoryTrans->productCategory;

            if (app('Category')->isEmpty($productCategory->TermekfaLevel_ID)) {
                return redirect()->to(LUrl::routeCategory($productCategory->parent));
            }

            $transes = ProductCategoryTrans::join('nyelv', 'termekfa_level_forditas.Nyelv_ID', '=', 'nyelv.Nyelv_ID')
                ->whereIn('nyelv.KodAlpha2', $lang->getLocales())
                ->where('termekfa_level_forditas.TermekfaLevel_ID', $productCategory->TermekfaLevel_ID)
                ->select(['nyelv.KodAlpha2', 'termekfa_level_forditas.Eleres'])->get();

            foreach ($transes as $trans) {
                $lang->setUrl($trans->KodAlpha2, LUrl::route('product.category.show', ['Eleres' => $trans->Eleres], false, $trans->KodAlpha2));
            }
        } else {
            $productCategory = null;

            foreach ($lang->getLocales() as $locale) {
                $lang->setUrl($locale, LUrl::routeCategory(null, [], $locale));
            }
        }

        return view('pages.product-categories.show', [
            'productCategory' => $productCategory,
            'navigator' => $this->renderNavigator($productCategory),
            'breadcrumbs' => $this->renderBreadcrumb($productCategory),
            'productList' => $this->renderProductList($productCategory, $request),
            'filters' => $this->renderFilters($request, $productCategory),
        ]);
    }

    /**
     * AJAX szál a kategória dobozok frissításére.
     */
    public function refresh(Request $request): array
    {
        $productCategory = null;

        if ($request->Eleres) {
            $productCategoryTrans = ProductCategoryTrans::getBySlug($request->Eleres);
            if (! $productCategoryTrans) {
                abort(404);
            }

            $productCategory = $productCategoryTrans->productCategory;
        }

        return [
            'microtime' => $request->microtime,
            'navigator' => $request->refreshNavigator == 'true' ? $this->renderNavigator($productCategory) : null,
            'breadcrumb' => $request->refreshBreadcrumb == 'true' ? $this->renderBreadcrumb($productCategory) : null,
            'filters' => $request->refreshFilters == 'true' ? $this->renderFilters($request, $productCategory) : null,
            'productList' => $request->refreshProducts == 'true' ? $this->renderProductList($productCategory, $request) : null,
        ];
    }

    public function renderNavigator(ProductCategory $productCategory = null): string
    {
        $category = app('Category');

        if ($productCategory === null) {
            $listedParentID = 0;
        } else {
            if ($category->hasChild($productCategory->TermekfaLevel_ID)) {
                $listedParentID = $productCategory->TermekfaLevel_ID;
            } else {
                $listedParentID = $productCategory->FelsoTermekfaLevel_ID;
            }
        }

        $childCategories = [];
        foreach ($category->getChildren($listedParentID) as $childCategory) {
            if (! $category->isEmpty($childCategory->TermekfaLevel_ID)) {
                $childCategories[] = $childCategory;
            }
        }

        return view('pages.product-categories.includes.navigator', [
            'isRoot' => $productCategory === null,
            // 'termekfaLevel' => $productCategory,
            'activeProductCategoryID' => $productCategory === null ? 0 : $productCategory->TermekfaLevel_ID,
            'parentProductCategory' => $productCategory === null ? null : $category->getParent($productCategory->TermekfaLevel_ID),
            'childCategories' => $childCategories,
        ])->render();
    }

    /**
     * Filterek legenerálása.
     */
    public function renderFilters(Request $request, ProductCategory $productCategory = null): string
    {
        $filterValues = $this->getFilterValues($productCategory);
        $attributeIds = array_unique(array_column($filterValues, 'Tulajdonsag_ID'));

        $formattedFilterValues = $this->formatFilterValues($filterValues);

        $user = app('User');

        $rangePrices = [];

        if ($user->isRielActive()) {
            $currencyID = $user->getCurrencyID();
            foreach (ProductCategory::getRangePrices($user->getGroupPaymentConditionID(), $currencyID, $productCategory) as $rangePrice) {
                $rangePrices[$rangePrice] = Fct::price(new Price($rangePrice, $currencyID));
            }
        }

        $attributes = $productCategory ? $productCategory->load(['attributes' => function ($query) use ($attributeIds) {
            $query->wherePivotIn('Tulajdonsag_ID', $attributeIds)
                ->where('Publikus', 1);
        }, 'attributes.trans'])->attributes : collect();

        $attributes = $attributes->map(function ($attribute) use ($formattedFilterValues, $request) {
            $attribute->values = $this->getAttributeValues($attribute, $formattedFilterValues, $request);

            return $attribute;
        })->reject(fn ($attribute) => ($attribute->Tipus === 'Intervallum' && count($attribute->values) < 2) || (count($attribute->values) < 1 && $attribute->Tipus !== 'Logikai'));

        return view('pages.product-categories.includes.filters.filters', [
            'productCategory' => $productCategory,
            'rangePrices' => $rangePrices,
            'manufacturers' => $this->getManufacturers($productCategory),
            'attributes' => $attributes,
        ])->render();
    }

    private function renderBreadcrumb(ProductCategory $productCategory = null): string
    {
        return (string) Breadcrumbs::render('product_category', $productCategory);
    }

    /**
     * Terméklista legenerálása.
     */
    private function renderProductList(ProductCategory $productCategory = null, Request $request): string
    {
        $products = Product::visible()
            ->category($productCategory)
            ->groupBy('termek.Termek_ID')
            ->extraData()
            ->select('termek.*');

        if ($request->has('kulcsszo') && $request->kulcsszo) {
            $products = $products->keyword(explode(',', $request->kulcsszo));
        }

        if ($request->has('projekt')) {
            $products = $products->project();
        }

        if ($request->has('ujdonsag')) {
            $products = $products->newness();
        }

        if ($request->has('kifuto')) {
            $products = $products->discounted();
        }

        if ($request->has('gyarto')) {
            $manufacturerIDs = explode('-', (string) $request->gyarto);
            if ($manufacturerIDs) {
                $products = $products->whereIn('termek.Gyarto_ID', $manufacturerIDs);
            }
        }

        if (app('User')->isRielActive()) {
            if ($request->has('akcios')) {
                $products = $products->sale($request->akcios === 'true' ? null : $request->akcios);
            }

            if ($request->has('ar')) {
                $price = explode('-', (string) $request->get('ar'));
                if ($price && count($price) == 2) {
                    $products = $products->price((int) $price[0], (int) $price[1]);
                }
            }

            if ($request->has('keszleten')) {
                $products = $products->inStock();
            }
        }

        $extraProperties = [];

        if ($productCategory !== null) {
            $urlNames = array_keys($request->all());
            if (count($urlNames) > 0) {
                $attributes = Attribute::join('termekfa_level_tulajdonsag', 'termekfa_level_tulajdonsag.Tulajdonsag_ID', '=', 'tulajdonsag.Tulajdonsag_ID')
                    ->where('TermekfaLevel_ID', $productCategory->TermekfaLevel_ID)
                    ->where('tulajdonsag.Publikus', 1)
                    ->whereIn('tulajdonsag.BelsoNev', $urlNames)
                    ->get();

                foreach ($attributes as $attribute) {
                    $extraProperties[] = $attribute->BelsoNev;
                    $values = explode('-', (string) $request->get($attribute->BelsoNev));
                    if ($values) {
                        if (count($values) == 2 && $attribute->Tipus == 'Intervallum') {
                            $ids = $attribute->values()
                                ->where('Sorrend', '>=', (int) $values[0])
                                ->where('Sorrend', '<=', (int) $values[1])
                                ->pluck('TulajdonsagTetel_ID')->toArray();

                            $products = $products->attribute($attribute->Tulajdonsag_ID, $ids);
                        } elseif (count($values) == 2 && $attribute->Tipus == 'val') {
                            $products = $products->rangeValue($attribute->BelsoNev, (float) $values[0], (float) $values[1]);
                        } elseif ($attribute->Tipus == 'Logikai') {
                            $products = $products->attributeBoolean($attribute->Tulajdonsag_ID, $request->get($attribute->BelsoNev) == 'true');
                        } elseif ($attribute->Tipus != 'Intervallum') {
                            // Felsorolt
                            foreach ($values as $i => $id) {
                                $values[$i] = (int) $id;
                            }
                            $products = $products->attribute($attribute->Tulajdonsag_ID, $values);
                        }
                    }
                }
            }
        }

        if (app('User')->isRielActive()) {
            $column = $request->has('rendezes') ? $request->rendezes : 'cikkszam';
        } else {
            $column = 'cikkszam';

            if ($request->has('rendezes')) {
                if ($request->rendezes !== 'ar') {
                    $column = $request->rendezes;
                }
            }
        }

        $direction = ! $request->has('rendezes-irany') || $request->get('rendezes-irany') == 'novekvo';

        $products = $products->order($column, $direction);

        // Maximális találatszám egy oldalon
        $results = 25;
        if ($request->has('talalatok-szama')) {
            $results = (int) $request->get('talalatok-szama');
            if ($results < 1) {
                $results = 1;
            } elseif ($results > 200) {
                $results = 200;
            }
        }

        $products->visibleForCustomer();

        $products = $products->paginate($results);

        $productSourceHandler = app('ProductSourceHandler');

        foreach ($products as $product) {
            $productSourceHandler->addProduct($product->Termek_ID);
            ProductAttributeList::preload($product->Termek_ID);
        }

        return view('pages.product-categories.includes.product-list', [
            'productCategory' => $productCategory,
            'products' => $products,
            'params' => $request->except(['page', 'microtime', 'TermekfaLevel_ID', 'refreshNavigator', 'refreshBreadcrumb', 'refreshFilters', 'refreshProducts']),
            'breadcrumbs' => $this->renderBreadcrumb($productCategory),
            'extraProperties' => $extraProperties,
        ])->render();
    }

    private function getFilterValues(?ProductCategory $productCategory): array
    {
        $blacklistedManufacturerIds = (new Manufacturer())->getBlacklistedIds();

        $productCategoryCriteria = '';

        if ($productCategory) {
            $productCategoryCriteria = 'tfl.Bal >= ' . (int) $productCategory->Bal . ' AND tfl.Jobb <= ' . (int) $productCategory->Jobb;
        }

        $sql = "
            SELECT * FROM (
                SELECT
                    t.Tulajdonsag_ID,
                    t.BelsoNev,
                    tt.TulajdonsagTetel_ID AS TulajdonsagTetel_ID,
                    IFNULL(ttf.Nev, tt.Nev) AS Nev,
                    tt.Sorrend,
                    t.Tipus,
                    null AS min,
                    null AS max,
                    tts.count as count
                FROM termekfa_level_tulajdonsag tlt
                INNER JOIN tulajdonsag t ON t.Tulajdonsag_ID = tlt.Tulajdonsag_ID
                INNER JOIN tulajdonsag_tetel tt ON tt.Tulajdonsag_ID = t.Tulajdonsag_ID
                INNER JOIN (
                    SELECT
                        tt.Tulajdonsag_ID, tt.TulajdonsagTetel_ID, count(tjoin.Termek_ID) as count
                    FROM tulajdonsag_tetel tt
                    INNER JOIN tulajdonsag t ON t.Tulajdonsag_ID = tt.Tulajdonsag_ID AND t.Tipus NOT IN ('val', 'min', 'max')
                    INNER JOIN termek_tulajdonsag tul ON tul.Tulajdonsag_ID = tt.Tulajdonsag_ID AND tul.TulajdonsagTetel_ID = tt.TulajdonsagTetel_ID
                    INNER JOIN (
                        SELECT t.Termek_ID
                        FROM termek t
                        INNER JOIN termek_termekfa tt
                        ON tt.Termek_ID = t.Termek_ID
                        INNER JOIN termekfa_level tfl
                        ON tfl.TermekfaLevel_ID = tt.TermekfaLevel_ID " . ($productCategoryCriteria === '' ? '' : 'AND ' . $productCategoryCriteria) . '
                        WHERE t.Aktiv = 1
                        AND t.Lathato = 1
                        AND t.Gyarto_ID NOT IN (' . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ")
                    ) tjoin ON tjoin.Termek_ID = tul.Termek_ID
                    GROUP BY tt.Tulajdonsag_ID, tt.TulajdonsagTetel_ID
                ) tts ON tts.Tulajdonsag_ID = tt.Tulajdonsag_ID AND tts.TulajdonsagTetel_ID = tt.TulajdonsagTetel_ID
                LEFT JOIN tulajdonsag_tetel_forditas ttf ON ttf.Tulajdonsag_ID = tt.Tulajdonsag_ID AND ttf.TulajdonsagTetel_ID = tt.TulajdonsagTetel_ID AND ttf.Nyelv_ID = ?
                WHERE tlt.TermekfaLevel_ID = ?

                UNION

                SELECT
                    t.Tulajdonsag_ID,
                    t.BelsoNev,
                    tt.TulajdonsagTetel_ID AS TulajdonsagTetel_ID,
                    tt.Nev AS Nev,
                    tt.Sorrend AS Sorrend,
                    'val' AS Tipus,
                    minSzam.Szam AS min,
                    maxSzam.Szam AS max,
                    null as count
                FROM tulajdonsag t
                INNER JOIN tulajdonsag_tetel tt ON tt.Tulajdonsag_ID = t.Tulajdonsag_ID
                LEFT JOIN (
                    SELECT  t.BelsoNev, min(tt.Szam) AS Szam
                    FROM termek_tulajdonsag tt
                    INNER JOIN tulajdonsag t ON t.Tulajdonsag_ID = tt.Tulajdonsag_ID
                    INNER JOIN (
                        SELECT t.Termek_ID
                        FROM termek t
                        INNER JOIN termek_termekfa tt
                        ON tt.Termek_ID = t.Termek_ID
                        INNER JOIN termekfa_level tfl
                        ON tfl.TermekfaLevel_ID = tt.TermekfaLevel_ID " . ($productCategoryCriteria === '' ? '' : 'AND ' . $productCategoryCriteria) . '
                        WHERE t.Aktiv = 1
                        AND t.Lathato = 1
                        AND t.Gyarto_ID NOT IN (' . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ")
                    ) tjoin ON tjoin.Termek_ID = tt.Termek_ID
                    WHERE t.Tipus= 'min'
                    GROUP BY t.Tulajdonsag_ID
                ) AS minSzam ON t.BelsoNev = minSzam.BelsoNev
                LEFT JOIN (
                    SELECT  t.BelsoNev, max(tt.Szam) AS Szam
                    FROM termek_tulajdonsag tt
                    INNER JOIN tulajdonsag t ON t.Tulajdonsag_ID = tt.Tulajdonsag_ID
                    INNER JOIN (
                        SELECT t.Termek_ID
                        FROM termek t
                        INNER JOIN termek_termekfa tt
                        ON tt.Termek_ID = t.Termek_ID
                        INNER JOIN termekfa_level tfl
                        ON tfl.TermekfaLevel_ID = tt.TermekfaLevel_ID " . ($productCategoryCriteria === '' ? '' : 'AND ' . $productCategoryCriteria) . '
                        WHERE t.Aktiv = 1
                        AND t.Lathato = 1
                        AND t.Gyarto_ID NOT IN (' . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ")
                    ) tjoin ON tjoin.Termek_ID = tt.Termek_ID
                    WHERE t.Tipus= 'max'
                    GROUP BY t.Tulajdonsag_ID
                ) AS maxSzam ON t.BelsoNev = maxSzam.BelsoNev
                INNER JOIN (
                    SELECT
                        tt.Tulajdonsag_ID, tt.TulajdonsagTetel_ID
                    FROM tulajdonsag_tetel tt
                    INNER JOIN tulajdonsag t ON t.Tulajdonsag_ID = tt.Tulajdonsag_ID  AND t.Tipus = 'val'
                    INNER JOIN termekfa_level_tulajdonsag tflt ON tflt.Tulajdonsag_ID = t.Tulajdonsag_ID
                    INNER JOIN termekfa_level tfl ON tfl.TermekfaLevel_ID = tflt.TermekfaLevel_ID
                    " . ($productCategoryCriteria === '' ? '' : 'WHERE ' . $productCategoryCriteria) . "
                    GROUP BY tt.Tulajdonsag_ID, tt.TulajdonsagTetel_ID
                ) tts ON tts.Tulajdonsag_ID = tt.Tulajdonsag_ID AND tts.TulajdonsagTetel_ID = tt.TulajdonsagTetel_ID
                WHERE t.Tipus = 'val'
            ) AS s
            ORDER BY s.Tulajdonsag_ID ASC, s.Sorrend ASC
		";

        $productCategoryId = $productCategory ? $productCategory->TermekfaLevel_ID : 0;

        return DB::select($sql, [app('Lang')->getLanguageId(), $productCategoryId]);
    }

    private function formatFilterValues(array $filterValues): array
    {
        $formattedFilterValues = [];

        foreach ($filterValues as $row) {
            if ($row->Tipus == 'Felsorolt') {
                $formattedFilterValues[$row->BelsoNev][$row->TulajdonsagTetel_ID] = ['name' => $row->Nev, 'count' => $row->count, 'checked' => false];
            } elseif ($row->Tipus == 'Intervallum') {
                $formattedFilterValues[$row->BelsoNev][$row->Sorrend] = $row->Nev;
            } elseif ($row->Tipus == 'val') {
                $value = (float) $row->Nev;
                if ($value >= $row->min && $value <= $row->max) {
                    $formattedFilterValues[$row->BelsoNev][(string) (float) $row->Nev] = $row->Nev;
                }
            }
        }

        return $formattedFilterValues;
    }

    private function getAttributeValues($attribute, array $formattedFilterValues, Request $request)
    {
        if (! $this->hasSeparatedAttributes($attribute['BelsoNev'])) {
            return $formattedFilterValues[$attribute['BelsoNev']] ?? [];
        }

        $values = collect($formattedFilterValues[$attribute['BelsoNev']]);
        $newValues = collect();

        foreach ($values as $key => $value) {
            $split = explode('/', $value['name']);

            if (count($split) > 1) {
                foreach ($split as $splitted) {
                    $this->addValue($key, $newValues, $splitted, $value);
                }

                continue;
            }

            $this->addValue($key, $newValues, $value['name'], $value);
        }

        $name = $attribute['BelsoNev'];
        $reduced = $request->has($name) ? $request->get($name) : '';
        $checkedValues = [];

        $keys = $newValues->keys()->sortByDesc(fn ($value) => strlen($value));

        foreach ($keys as $key) {
            if (str_contains($reduced, $key)) {
                $checkedValues[] = $key;
                $reduced = str_replace($key, '', $reduced);

                $str = Str::of($reduced);

                if ($str->startsWith('-')) {
                    $reduced = $str->substr(0, 1);
                }

                if ($str->endsWith('-')) {
                    $reduced = $str->substr($str->length() - 1, 1);
                }
            }
        }

        return $newValues->transform(function ($value, $key) use ($checkedValues) {
            $value['checked'] = in_array($key, $checkedValues);

            return $value;
        })->sortBy('name');
    }

    private function addValue($key, &$values, string $name, $value)
    {
        $existingValue = $values->filter(fn ($value) => $value['name'] === $name)->first();

        if (! $existingValue) {
            $values[$key] = [
                'name' => $name,
                'count' => $value['count'],
                'checked' => false,
            ];
        } else {
            $existingKey = $values->search(fn ($value) => $value === $existingValue);

            $values["{$existingKey}-{$key}"] = [
                'name' => $name,
                'count' => $value['count'] + $existingValue['count'],
                'checked' => false,
            ];

            unset($values[$existingKey]);
        }
    }

    private function hasSeparatedAttributes(string $attributeName): bool
    {
        return in_array($attributeName, [
            'tapellatas',
        ]);
    }

    private function getManufacturers(?ProductCategory $productCategory)
    {
        return Manufacturer::productCategory($productCategory)
            ->withoutBlacklisted()
            ->get();
    }
}
