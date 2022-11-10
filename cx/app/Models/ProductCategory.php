<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Model
{
    protected $table = 'termekfa_level';
    protected $primaryKey = 'TermekfaLevel_ID';

    private static $slugs = [];

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'FelsoTermekfaLevel_ID', 'TermekfaLevel_ID')->orderBy('Sorrend');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'FelsoTermekfaLevel_ID', 'TermekfaLevel_ID');
    }

    public function scopeWhereParent($query, string $alias = 'termekfa_level')
    {
        return $query->where($alias . '.FelsoTermekfaLevel_ID', 0);
    }

    public function scopeWhereDoesntHaveBlacklistedProduct($query, string $alias = 'termekfa_level')
    {
        $query->whereExists(function ($query) use ($alias) {
            $query->select(DB::raw(1))
                ->from('termek as t')
                ->join('termek_termekfa', 'termek_termekfa.Termek_ID', '=', 't.Termek_ID')
                ->join('termekfa_level', 'termekfa_level.TermekfaLevel_ID', '=', 'termek_termekfa.TermekfaLevel_ID')
                ->whereIn('termekfa_level.TermekfaLevel_ID', function ($query) use ($alias) {
                    $query
                        ->select('TermekfaLevel_ID')
                        ->from('termekfa_level as tl2')
                        ->whereRaw('`tl2`.`Bal` >= `' . $alias . '`.`Bal`')
                        ->whereRaw('`tl2`.`Jobb` <= `' . $alias . '`.`Jobb`');
                })
                ->where([
                    ['t.Aktiv', 1],
                    ['t.Lathato', 1],
                ])
                ->whereNotIn('t.Gyarto_ID', (new Manufacturer())->getBlacklistedIds());
        });
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'termekfa_level_tulajdonsag', 'TermekfaLevel_ID', 'Tulajdonsag_ID')
            ->orderBy('termekfa_level_tulajdonsag.Sorrend');
    }

    public function whitelistedAttributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'termekfa_level_tulajdonsag', 'TermekfaLevel_ID', 'Tulajdonsag_ID')
            ->orderBy('termekfa_level_tulajdonsag.Sorrend');
    }

    public function trans()
    {
        return $this->belongsTo(ProductCategoryTrans::class, 'TermekfaLevel_ID', 'TermekfaLevel_ID')
            ->where('Nyelv_ID', app('Lang')->getLanguageId());
    }

    public function getSlug($locale = null)
    {
        if ($locale === null) {
            $locale = app('Lang')->getLocale();
        }

        if (! array_key_exists($locale, self::$slugs)) {
            self::$slugs[$locale] = ProductCategoryTrans::join('nyelv', 'nyelv.Nyelv_ID', '=', 'termekfa_level_forditas.Nyelv_ID')
                ->where('nyelv.KodAlpha2', $locale)
                ->select(['termekfa_level_forditas.TermekfaLevel_ID', 'termekfa_level_forditas.Eleres'])
                ->pluck('termekfa_level_forditas.Eleres', 'termekfa_level_forditas.TermekfaLevel_ID')
                ->toArray();
        }

        return array_key_exists($this->TermekfaLevel_ID, self::$slugs[$locale]) ? self::$slugs[$locale][$this->TermekfaLevel_ID] : '';
    }

    public static function getRangePrices($groupPaymentConditionID, $currencyID, ProductCategory $productCategory = null): array
    {
        $numSteps = 100;

        $blacklistedManufacturerIds = (new Manufacturer())->getBlacklistedIds();

        if ($productCategory === null) {
            $sql = '
                SELECT cast(ifnull(tua.UgyfelAr, ifnull(ta.AkciosAr, ta.ListaAr)) as decimal) AS Ar
                FROM termek t
                INNER JOIN view_termek_ar ta ON ta.Termek_ID = t.Termek_ID AND ta.Deviza_ID = ?
                INNER JOIN view_termek_ugyfel_ar tua ON tua.Termek_ID = t.Termek_ID AND tua.CsopFizetesiFeltetel_ID = ?  AND tua.Deviza_ID = ?
                WHERE t.Aktiv = 1 AND t.Lathato = 1 AND cast(ifnull(tua.UgyfelAr, ifnull(ta.AkciosAr, ta.ListaAr)) as decimal) > 0
                AND t.Gyarto_ID NOT IN (' . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ')
                GROUP BY cast(ifnull(tua.UgyfelAr, ifnull(ta.AkciosAr, ta.ListaAr)) as decimal)
                ORDER BY Ar
             ';
            $prices = DB::select($sql, [$currencyID, $groupPaymentConditionID, $currencyID]);
        } else {
            $sql = '
                SELECT cast(ifnull(tua.UgyfelAr, ifnull(ta.AkciosAr, ta.ListaAr)) as decimal) AS Ar
                FROM termek t
                INNER JOIN termek_termekfa ttf ON ttf.Termek_ID = t.Termek_ID
                INNER JOIN termekfa_level tf ON tf.TermekfaLevel_ID = ttf.TermekfaLevel_ID
                INNER JOIN view_termek_ar ta ON ta.Termek_ID = t.Termek_ID AND ta.Deviza_ID = ?
                INNER JOIN view_termek_ugyfel_ar tua ON tua.Termek_ID = t.Termek_ID AND tua.CsopFizetesiFeltetel_ID = ?  AND tua.Deviza_ID = ?
                WHERE t.Aktiv = 1 AND t.Lathato = 1 AND tf.Bal >=? AND tf.Jobb <= ? AND cast(ifnull(tua.UgyfelAr, ifnull(ta.AkciosAr, ta.ListaAr)) as decimal) > 0
                AND t.Gyarto_ID NOT IN (' . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ')
                GROUP BY cast(ifnull(tua.UgyfelAr, ifnull(ta.AkciosAr, ta.ListaAr)) as decimal)
                ORDER BY Ar
             ';
            $prices = DB::select($sql, [$currencyID, $groupPaymentConditionID, $currencyID, $productCategory->Bal, $productCategory->Jobb]);
        }

        $result = [];

        $count = count($prices);
        if ($count < 3 || $count <= $numSteps) {
            foreach ($prices as $price) {
                $result[] = $price->Ar;
            }
        } else {
            $step = $count / ($numSteps - 1);
            $i = 0;
            while (isset($prices[(int) $i])) {
                $result[] = $prices[(int) $i]->Ar;
                $i += $step;
            }
            $result[] = $prices[$count - 1]->Ar;
        }

        return $result;
    }

    public function getIcon()
    {
        switch ($this->TermekfaLevel_ID) {
            case 1:
                return 'fa-camera-cctv';

            case 2:
                return 'fa-fire';

            case 3:
                return 'fa-sensor-alert';

            case 255:
                return 'fa-network-wired';

            case 76:
                return 'fa-door-open';

            case 300:
                return 'fa-garage';

            case 107:
                return 'fa-phone-volume';

            case 361:
                return 'fa-lightbulb-exclamation-on';

            default:
                return 'fa-tag';
        }
    }
}
