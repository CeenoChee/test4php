<?php

namespace App\Libs;

use Illuminate\Support\Facades\DB;

class ProductAttributeList
{
    private static $preloadAll = false;
    private static $preload = [];
    private static $data = [];
    private static $isLoaded = false;

    private $productID;
    private $extra = [];
    private $limit;

    public function __construct($productID)
    {
        $this->productID = $productID;
        self::preload($productID);
    }

    public function __toString()
    {
        $attributes = [];
        foreach ($this->get() as $item) {
            $attributes[] = $item->getName() . ': ' . $item->getValue();
        }

        return implode(',', $attributes);
    }

    public static function preload($productID)
    {
        if (! in_array($productID, self::$preload)) {
            self::$preload[] = (int) $productID;
            self::$preloadAll = false;
        }
    }

    public static function preloadAll()
    {
        self::$preloadAll = true;
        self::$preload = [];
        self::$isLoaded = false;
    }

    public function limit($limit)
    {
        $this->limit = ($limit === null ? null : (int) $limit);

        return $this;
    }

    public function extra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    public function get()
    {
        if (! self::$isLoaded) {
            self::selectAttributes();
        }

        if (! isset(self::$data[$this->productID])) {
            return [];
        }

        if ($this->limit === null) {
            $items = self::$data[$this->productID];
        } else {
            $items = array_slice(self::$data[$this->productID], 0, $this->limit);
        }

        if (count($this->extra)) {
            foreach ($this->extra as $belsoNev) {
                if (! array_key_exists($belsoNev, $items) && array_key_exists($belsoNev, self::$data[$this->productID])) {
                    $items[$belsoNev] = self::$data[$this->productID][$belsoNev];
                }
            }
        }

        return $items;
    }

    private static function selectAttributes()
    {
        $langID = app('Lang')->getLanguageId();

        $productCriteria = self::$preloadAll || ! count(self::$preload) ? '' : ' AND t.Termek_ID IN (' . implode(',', self::$preload) . ')';
        $productValCriteria = self::$preloadAll || ! count(self::$preload) ? '' : ' AND t.Termek_ID IN (
            SELECT sttul.Termek_ID
            FROM termek_tulajdonsag sttul
            INNER JOIN tulajdonsag stul ON stul.Tulajdonsag_ID = sttul.Tulajdonsag_ID
            WHERE sttul.Termek_ID IN (' . implode(',', self::$preload) . ") AND stul.Tipus IN ('min', 'max')
            GROUP BY sttul.Termek_ID
        )";

        $sql = "
            SELECT * FROM (
                SELECT
                    t.Termek_ID AS Termek_ID,
                    tul.BelsoNev AS BelsoNev,
                    IFNULL(tulf.Cimke, tul.Cimke) AS Nev,
                    CASE WHEN tul.Tipus = 'Logikai' THEN tt.Logikai ELSE IFNULL(ttf.Nev, tult.Nev) END AS Ertek,
                    tul.Tipus AS Tipus,
                    null AS minSzam,
                    null AS maxSzam,
                    tcst.Sorrend
                FROM termek t
                INNER JOIN tulajdonsag_csoport_tetel tcst ON tcst.TulajdonsagCsoport_ID = t.TulajdonsagCsoport_ID
                INNER JOIN tulajdonsag tul ON tul.Tulajdonsag_ID = tcst.Tulajdonsag_ID
                INNER JOIN termek_tulajdonsag tt ON tt.Termek_ID = t.Termek_ID AND tt.Tulajdonsag_ID = tul.Tulajdonsag_ID
                LEFT JOIN tulajdonsag_forditas tulf ON  tulf.Tulajdonsag_ID = tul.Tulajdonsag_ID AND tulf.Nyelv_ID = " . $langID . '
                LEFT JOIN tulajdonsag_tetel tult ON tult.Tulajdonsag_ID = tt.Tulajdonsag_ID AND tult.TulajdonsagTetel_ID = tt.TulajdonsagTetel_ID
                LEFT JOIN tulajdonsag_tetel_forditas ttf ON ttf.Tulajdonsag_ID = tt.Tulajdonsag_ID AND ttf.TulajdonsagTetel_ID = tt.TulajdonsagTetel_ID AND ttf.Nyelv_ID = ' . $langID . "
                WHERE  tul.Tipus NOT IN ('val', 'min', 'max', 'Szoveg') " . $productCriteria . '

                UNION

                SELECT
                    t.Termek_ID AS Termek_ID,
                    tul.BelsoNev AS BelsoNev,
                    IFNULL(tulf.Cimke, tul.Cimke) AS Nev,
                    tt.Szoveg AS Ertek,
                    tul.Tipus AS Tipus,
                    null AS minSzam,
                    null AS maxSzam,
                    tcst.Sorrend
                FROM termek t
                INNER JOIN tulajdonsag_csoport_tetel tcst ON tcst.TulajdonsagCsoport_ID = t.TulajdonsagCsoport_ID
                INNER JOIN tulajdonsag tul ON tul.Tulajdonsag_ID = tcst.Tulajdonsag_ID
                INNER JOIN termek_tulajdonsag tt ON tt.Termek_ID = t.Termek_ID AND tt.Tulajdonsag_ID = tul.Tulajdonsag_ID
                LEFT JOIN tulajdonsag_forditas tulf ON  tulf.Tulajdonsag_ID = tul.Tulajdonsag_ID AND tulf.Nyelv_ID = ' . $langID . "
                WHERE  tul.Tipus = 'Szoveg' " . $productCriteria . "

                UNION

                SELECT
                    t.Termek_ID AS Termek_ID,
                    tul.BelsoNev AS BelsoNev,
                    IFNULL(tulf.Cimke, tul.Cimke) AS Nev,
                    null AS Ertek,
                    'val' AS Tipus,
                    CONCAT(CONCAT(CAST(CAST(mintt.Szam as DECIMAL(18,6)) as float), ' '), mintul.MennyisegEgyseg) AS minSzam,
                    CONCAT(CONCAT(CAST(CAST(maxtt.Szam as DECIMAL(18,6)) as float), ' '), maxtul.MennyisegEgyseg) AS maxSzam,
                    tcst.Sorrend
                FROM termek t
                INNER JOIN tulajdonsag_csoport_tetel tcst ON tcst.TulajdonsagCsoport_ID = t.TulajdonsagCsoport_ID
                INNER JOIN tulajdonsag tul ON tul.Tulajdonsag_ID = tcst.Tulajdonsag_ID
                LEFT JOIN tulajdonsag_forditas tulf ON  tulf.Tulajdonsag_ID = tul.Tulajdonsag_ID AND tulf.Nyelv_ID = " . $langID . "

                LEFT JOIN tulajdonsag mintul ON mintul.Tipus = 'min' AND mintul.Cimke = tul.Cimke
                LEFT JOIN termek_tulajdonsag mintt ON mintt.Tulajdonsag_ID = mintul.Tulajdonsag_ID AND mintt.Termek_ID = t.Termek_ID

                LEFT JOIN tulajdonsag maxtul ON maxtul.Tipus = 'max' AND maxtul.Cimke = tul.Cimke
                LEFT JOIN termek_tulajdonsag maxtt ON maxtt.Tulajdonsag_ID = maxtul.Tulajdonsag_ID AND maxtt.Termek_ID = t.Termek_ID

                WHERE tul.Tipus = 'val'" . $productValCriteria . '
            ) AS s
            ORDER BY s.Sorrend ASC
        ';

        $rows = DB::connection('mysql')->select($sql);

        foreach ($rows as $row) {
            if ($row->Tipus == 'Logikai') {
                $value = ((int) $row->Ertek ? trans('global.yes') : trans('global.no'));
            } elseif ($row->Tipus == 'val') {
                $min = $row->minSzam;
                $max = $row->maxSzam;
                if ($min !== null || $max !== null) {
                    if ($min == $max) {
                        $value = $min;
                    } else {
                        $value = $min . ' - ' . $max;
                    }
                } elseif ($min === null && $max === null) {
                    $value = null;
                } else {
                    $value = $min === null ? $max : $min;
                }
            } else {
                $value = $row->Ertek;
            }
            if ($value !== null) {
                self::$data[$row->Termek_ID][$row->BelsoNev] = new AttributeProduct($row->BelsoNev, $row->Nev, $value);
            }
        }

        self::$preload = [];
        self::$isLoaded = true;

        return true;
    }
}
