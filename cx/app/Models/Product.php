<?php

namespace App\Models;

use App\Classes\Media\Collections;
use App\Libs\Fct;
use App\Libs\Price;
use App\Libs\ProductAttributeList;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasMedia;

    protected $table = 'termek';
    protected $primaryKey = 'Termek_ID';

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'Gyarto_ID');
    }

    public function getProductAttributes(): ProductAttributeList
    {
        return new ProductAttributeList($this->Termek_ID);
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'model', 'media_model')
            ->where('custom_properties->public', 'true')
            ->where('media.collection_name', 'image');
    }

    public function trans(): BelongsTo
    {
        return $this->belongsTo(ProductTrans::class, 'Termek_ID', 'Termek_ID')
            ->where('Nyelv_ID', app('Lang')->getLanguageId());
    }

    public function price()
    {
        return $this->hasOne(ProductPrice::class, 'Termek_ID')->currency();
    }

    public function customerPrice()
    {
        $groupPaymentConditionID = app('User')->getGroupPaymentConditionID();

        return $this->hasOne(ProductCustomerPrice::class, 'Termek_ID')->where(
            'CsopFizetesiFeltetel_ID',
            $groupPaymentConditionID
        )->currency();
    }

    public function installerPrice()
    {
        return $this->hasOne(ProductCustomerPrice::class, 'Termek_ID')->where('CsopFizetesiFeltetel_ID', 4)->currency();
    }

    public function getCustomerPrice(): ?Price
    {
        $customerPrice = $this->customerPrice;
        if ($customerPrice and $customerPrice->UgyfelAr !== null) {
            return new Price($customerPrice->UgyfelAr, $customerPrice->Deviza_ID);
        }

        return null;
    }

    public function getPrices()
    {
        $user = app('User');

        $price = new \stdClass();
        $price->ListaAr = null;
        $price->AkciosAr = null;
        $price->TelepitoiAr = null;
        $price->UgyfelAr = null;

        if ($user->isRielActive()) {
            $productPrice = $this->price;
            if ($productPrice) {
                $price->ListaAr = $productPrice->ListaAr ? new Price(
                    $productPrice->ListaAr,
                    $productPrice->Deviza_ID
                ) : null;
                $price->AkciosAr = $productPrice->AkciosAr ? new Price(
                    $productPrice->AkciosAr,
                    $productPrice->Deviza_ID
                ) : null;
                $price->AkcioNev = $productPrice->AkcioNev;
                if ($price->ListaAr) {
                    $customerPrice = $this->getCustomerPrice();
                    $price->UgyfelAr = $customerPrice === null ? $price->ListaAr : $customerPrice;
                }
            }
        }

        if ($user->isReseller()) {
            $installerPrice = $this->installerPrice;
            if ($installerPrice) {
                $price->TelepitoiAr = new Price($installerPrice->UgyfelAr, $installerPrice->Deviza_ID);
            }
        }

        return $price;
    }

    public function productClassifications()
    {
        return $this->hasMany(ProductClassification::class, 'Termek_ID');
    }

    public function scopeActive($query)
    {
        return $query->where('Aktiv', 1);
    }

    public function scopeVisible($query)
    {
        return $query->active()->where('Lathato', 1);
    }

    public function scopeExtraData($query)
    {
        $methods = [
            'manufacturer',
            'trans',
            'unit',
        ];

        $user = app('User');

        if ($user->isRielActive()) {
            $methods = array_merge(
                $methods,
                [
                    'stock',
                    'price',
                    'customerPrice',
                ]
            );
        }

        if ($user->isReseller()) {
            $methods[] = 'installerPrice';
        }

        return $query->with($methods);
    }

    public function scopeItProduct($query)
    {
        return $query->where('ItTermek', 1);
    }

    public function scopeDiscounted($query)
    {
        return $query->where('Kifuto', 1);
    }

    public function scopeProject($query)
    {
        return $query->where('Projekt', 1);
    }

    public function scopeOrder($query, $type, $asc = true)
    {
        if ($type == 'cikkszam') {
            return $query->orderBy('termek.Kod', $asc ? 'asc' : 'desc');
        }
        if ($type == 'nev') {
            return $query->orderBy('termek.Nev', $asc ? 'asc' : 'desc');
        }
        if ($type == 'ar') {
            return $query->join(
                'view_termek_ugyfel_ar AS ar_rendezes',
                'ar_rendezes.Termek_ID',
                '=',
                'termek.Termek_ID'
            )
                ->where('ar_rendezes.Deviza_ID', app('User')->getCurrencyID())
                ->where('ar_rendezes.CsopFizetesiFeltetel_ID', app('User')->getGroupPaymentConditionID())
                ->orderBy('ar_rendezes.UgyfelAr', $asc ? 'asc' : 'desc')
                ->groupBy('ar_rendezes.UgyfelAr');
        }

        return $query;
    }

    public function scopeNewness($query)
    {
        return $query->where('Ujdonsag', 1);
    }

    public function scopeInStock($query)
    {
        return $query->join('keszlet', 'keszlet.Termek_ID', '=', 'termek.Termek_ID')
            ->join('raktar', 'raktar.Raktar_ID', '=', 'keszlet.Raktar_ID')
            ->whereIn('raktar.Kod', config('riel.warehouse.inner', []));
    }

    public function scopeSale($query, $saleNameSlug = null)
    {
        if (! is_null($saleNameSlug)) {
            $sales = [];
            foreach (ProductPrice::whereNotNull('AkcioNev')->groupBy('AkcioNev')->select('AkcioNev')->get() as $akcio) {
                $sales[Fct::slugify($akcio->AkcioNev)] = $akcio->AkcioNev;
            }

            $saleName = $sales[$saleNameSlug] ?? null;

            if ($saleName) {
                return $query->join('view_termek_ar AS akcios', 'akcios.Termek_ID', '=', 'termek.Termek_ID')
                    ->where('akcios.Deviza_ID', app('User')->getCurrencyID())
                    ->where('akcios.AkcioNev', $saleName);
            }
        }

        return $query->join('view_termek_ar AS akcios', 'akcios.Termek_ID', '=', 'termek.Termek_ID')
            ->where('akcios.Deviza_ID', app('User')->getCurrencyID())
            ->where(function ($query) {
                $query->whereNotNull('akcios.AkciosAr')
                    ->orWhereNotNull('akcios.AkcioNev');
            });
    }

    public function scopeMinPrice($query, $minPrice)
    {
        return $query->join('view_termek_ugyfel_ar AS minPrice', 'termek.Termek_ID', '=', 'minPrice.Termek_ID')
            ->where('minPrice.Deviza_ID', app('User')->getCurrencyID())
            ->where('minPrice.CsopFizetesiFeltetel_ID', app('User')->getGroupPaymentConditionID())
            ->where('minPrice.UgyfelAr', '>=', $minPrice);
    }

    public function scopeMaxPrice($query, $maxPrice)
    {
        return $query->join('view_termek_ugyfel_ar AS maxPrice', 'termek.Termek_ID', '=', 'maxPrice.Termek_ID')
            ->where('maxPrice.Deviza_ID', app('User')->getCurrencyID())
            ->where('maxPrice.CsopFizetesiFeltetel_ID', app('User')->getGroupPaymentConditionID())
            ->where('maxPrice.UgyfelAr', '<=', $maxPrice);
    }

    public function scopePrice($query, $minPrice, $maxPrice)
    {
        return $query->join('view_termek_ugyfel_ar AS price', 'termek.Termek_ID', '=', 'price.Termek_ID')
            ->where('price.Deviza_ID', app('User')->getCurrencyID())
            ->where('price.CsopFizetesiFeltetel_ID', app('User')->getGroupPaymentConditionID())
            ->where(DB::raw('cast(price.UgyfelAr AS decimal)'), '<=', $maxPrice)
            ->where(DB::raw('cast(price.UgyfelAr AS decimal)'), '>=', $minPrice);
    }

    public function scopeCategory($query, ProductCategory $productCategory = null)
    {
        if ($productCategory === null) {
            return $query;
        }

        return $query->join('termek_termekfa', 'termek_termekfa.Termek_ID', '=', 'termek.Termek_ID')
            ->join('termekfa_level', 'termekfa_level.TermekfaLevel_ID', '=', 'termek_termekfa.TermekfaLevel_ID')
            ->where('termekfa_level.Bal', '>=', $productCategory->Bal)
            ->where('termekfa_level.Jobb', '<=', $productCategory->Jobb);
    }

    public function categories()
    {
        return $this->hasMany(TermekTermekfa::class, 'Termek_ID');
    }

    public function getPrimaryCategory()
    {
        return $this->categories->first();
    }

    public function scopeOutlet($query)
    {
        return $query->discounted()->inStock()->sale();
    }

    public function scopeKeyword($query, $keyword)
    {
        if (! is_array($keyword)) {
            $keyword = [(string) $keyword];
        }

        if (! count($keyword) || empty($keyword[0])) {
            return $query;
        }

        $sql = [];
        $parameters = [];
        foreach ($keyword as $word) {
            $sql[] = '(termek.Kod LIKE ? OR termek.Nev LIKE ? OR manufacturers.Nev LIKE ?)';
            for ($i = 0; $i < 3; ++$i) {
                $parameters[] = '%' . $word . '%';
            }
        }

        return $query->leftJoin('manufacturers', 'manufacturers.Gyarto_ID', '=', 'termek.Gyarto_ID')
            ->whereRaw(implode(' AND ', $sql), $parameters);
    }

    public function scopeAttribute($query, $attributeID, $attributeValueIDs)
    {
        return $query->join(
            'termek_tulajdonsag AS tul_' . $attributeID,
            function ($join) use ($attributeID, $attributeValueIDs) {
                $join->on('termek.Termek_ID', '=', 'tul_' . $attributeID . '.Termek_ID')
                    ->where('tul_' . $attributeID . '.Tulajdonsag_ID', '=', $attributeID)
                    ->whereIn('tul_' . $attributeID . '.TulajdonsagTetel_ID', $attributeValueIDs);
            }
        );
    }

    public function scopeRangeValue($query, $innerName, $min, $max)
    {
        return $query->minValue($innerName, $min)->maxValue($innerName, $max);
    }

    public function scopeMinValue($query, $innerName, $min)
    {
        return $query->join(
            'termek_tulajdonsag AS ttul_min_' . $innerName,
            'ttul_min_' . $innerName . '.Termek_ID',
            '=',
            'termek.Termek_ID'
        )
            ->join(
                'tulajdonsag AS tul_min_' . $innerName,
                'tul_min_' . $innerName . '.Tulajdonsag_ID',
                '=',
                'ttul_min_' . $innerName . '.Tulajdonsag_ID'
            )
            ->where('ttul_min_' . $innerName . '.TulajdonsagTetel_ID', 0)
            ->where('tul_min_' . $innerName . '.BelsoNev', $innerName)
            ->where('tul_min_' . $innerName . '.Tipus', 'min')
            ->where('ttul_min_' . $innerName . '.Szam', '>=', (float) $min);
    }

    public function scopeMaxValue($query, $innerName, $max)
    {
        return $query->join(
            'termek_tulajdonsag AS ttul_max_' . $innerName,
            'ttul_max_' . $innerName . '.Termek_ID',
            '=',
            'termek.Termek_ID'
        )
            ->join(
                'tulajdonsag AS tul_max_' . $innerName,
                'tul_max_' . $innerName . '.Tulajdonsag_ID',
                '=',
                'ttul_max_' . $innerName . '.Tulajdonsag_ID'
            )
            ->where('ttul_max_' . $innerName . '.TulajdonsagTetel_ID', 0)
            ->where('tul_max_' . $innerName . '.BelsoNev', $innerName)
            ->where('tul_max_' . $innerName . '.Tipus', 'max')
            ->where('ttul_max_' . $innerName . '.Szam', '<=', (float) $max);
    }

    public function scopeAttributeBoolean($query, $attributeID, $value)
    {
        return $query->join(
            'termek_tulajdonsag AS tul_' . $attributeID,
            function ($join) use ($attributeID, $value) {
                $join->on('termek.Termek_ID', '=', 'tul_' . $attributeID . '.Termek_ID')
                    ->where('tul_' . $attributeID . '.Tulajdonsag_ID', '=', $attributeID)
                    ->where('tul_' . $attributeID . '.TulajdonsagTetel_ID', 0)
                    ->where('tul_' . $attributeID . '.Logikai', (int) $value);
            }
        );
    }

    public function scopeVisibleForCustomer($query)
    {
        return $query->whereNotIn('termek.Gyarto_ID', (new Manufacturer())->getBlacklistedIds());
    }

    public function getStockLimit()
    {
        $stock = $this->Kifuto || $this->KeszletErejeig ? $this->getStock() : null;

        if ($stock === null && $this->MaxRendelheto === null) {
            $limit = null;
        } elseif ($stock !== null && $this->MaxRendelheto !== null) {
            $limit = max($stock, $this->MaxRendelheto);
        } elseif ($stock) {
            $limit = $stock;
        } else {
            $limit = $this->MaxRendelheto;
        }

        return $limit;
    }

    public function stock()
    {
        return $this->hasMany(Stock::class, 'Termek_ID')
            ->join('raktar', 'raktar.Raktar_ID', '=', 'keszlet.Raktar_ID');
    }

    public function getStock()
    {
        $freeStock = 0;
        $innerWarehouse = config('riel.warehouse.inner', []);
        foreach ($this->stock as $stock) {
            if (in_array($stock->Kod, $innerWarehouse)) {
                $freeStock += $stock->SzabadMennyiseg;
            }
        }

        return $freeStock;
    }

    public function deliveryTime()
    {
        return $this->hasMany(DeliveryTime::class, 'Termek_ID')
            ->orderBy('szall_hatarido.SzallHatIdo');
    }

    public function freeStock()
    {
        return $this->stock;
    }

    /**
     * Visszaadja szálllítási határidőt.
     *
     * @param int $qty
     *
     * @return mixed
     */
    public function getDeliveryTime($qty = 1)
    {
        return app('ProductSourceHandler')->getDeliveryTime($this->Termek_ID, $qty);
    }

    public function isSale()
    {
        $productPrice = $this->price;

        return $productPrice && ($productPrice->AkciosAr !== null || $productPrice->AkcioNev !== null);
    }

    public function additional()
    {
        return Product::join(
            'termek_kiegeszitotermek',
            'termek_kiegeszitotermek.KiegeszitoTermek_ID',
            '=',
            'termek.Termek_ID'
        )
            ->where('termek_kiegeszitotermek.Termek_ID', $this->Termek_ID)
            ->select('termek.*')
            ->visibleForCustomer();
    }

    public function replacement()
    {
        return Product::join(
            'termek_helyettesitotermek',
            'termek_helyettesitotermek.HelyettesitoTermek_ID',
            '=',
            'termek.Termek_ID'
        )
            ->where('termek_helyettesitotermek.Termek_ID', $this->Termek_ID)
            ->select('termek.*')
            ->visibleForCustomer();
    }

    public function related()
    {
        return Product::join(
            'termek_kapcsolodotermek',
            'termek_kapcsolodotermek.KapcsolodoTermek_ID',
            '=',
            'termek.Termek_ID'
        )
            ->where('termek_kapcsolodotermek.Termek_ID', $this->Termek_ID)->select('termek.*')
            ->visibleForCustomer();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'MennyisegEgyseg_ID', 'MennyisegEgyseg_ID');
    }

    public function getDatasheets()
    {
        return $this->getMediaByCollection('datasheet')->get();
    }

    public function getDownloadableCollections()
    {
        return array_diff(Collections::COLLECTIONS, ['icon', 'image']);
    }

    public function getDownloadableMedia()
    {
        return $this->media()->where('custom_properties->public', 'true')
            ->whereIn('media.collection_name', $this->getDownloadableCollections())->orderBy('media.collection_name');
    }

    public function scopeWithNonBlacklistedManufacturer($query)
    {
        $query->whereNotIn('Gyarto_ID', (new Manufacturer())->getBlacklistedIds());
    }
}
