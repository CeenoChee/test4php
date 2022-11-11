<?php

namespace App\Libs\DeliveryTime;

use App\Libs\Enums\Shipping;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class ProductSourceHandler
{
    private $products = [];
    private $sources;
    private $shipping;
    private $warehouse;

    public function __construct(Shipping $shipping, Warehouse $warehouse = null)
    {
        $this->shipping = $shipping;
        $this->warehouse = $warehouse;
    }

    public function setWarehouse(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
        $this->sources = null;

        return $this;
    }

    public function getWarehouse()
    {
        if ($this->warehouse === null) {
            $this->warehouse = Warehouse::where('Kod', config('riel.warehouse.default'))->first();
        }

        return $this->warehouse;
    }

    public function addProduct($productID)
    {
        $this->products[$productID] = true;
        $this->sources = null;
    }

    public function isAdded($productID)
    {
        return array_key_exists($productID, $this->products);
    }

    public function getProductIDs()
    {
        return array_keys($this->products);
    }

    public function getAllSource($productID)
    {
        if (! count($this->products)) {
            return [];
        }

        if ($this->sources === null) {
            $productIDs = implode(',', $this->getProductIDs());

            $innerWarehouses = implode("','", config('riel.warehouse.inner', []));
            $externalWarehouses = implode("','", config('riel.warehouse.external', []));

            $warehouse = $this->getWarehouse();
            $warehouseCondition = ($warehouse === null ? 'rszi.CelRaktar_ID = r.Raktar_ID' : 'rszi.CelRaktar_ID = ' . (int) $warehouse->Raktar_ID);

            $sql = "
			SELECT * FROM (
				SELECT
					'gyartas' AS Tipus,
					t.Termek_ID AS Termek_ID,
					IF(DATE(DATE_ADD(NOW(), INTERVAL t.SzallIdoOra HOUR)) > IFNULL(rszh.RendSzallHatido, '1970-01-01'), DATE(DATE_ADD(NOW(), INTERVAL t.SzallIdoOra HOUR)), rszh.RendSzallHatido) AS SzallIdo,
					null AS Mennyiseg,
					'Rendelni' AS ForrasNev,
					null AS Raktar_ID,
					null AS AruforgBiz_ID,
					null AS AruforgBizTetel_ID,
					null AS AruforgBizValasz_ID,
					null AS AruforgBizValaszTetel_ID
				FROM termek t
			    LEFT JOIN (select Termek_ID, MAX(SzallHatIdo) RendSzallHatido from szall_hatarido group by Termek_ID) rszh ON rszh.Termek_ID = t.Termek_ID
				WHERE
					t.Termek_ID IN (" . $productIDs . ") AND
					t.SzallIdoOra IS NOT NULL
			UNION
				SELECT
					'keszlet' AS Tipus,
					k.Termek_ID AS Termek_ID,
					IF(rszi.Hatarido >= TIME(NOW()),
                      DATE_ADD(DATE(NOW()),
                      INTERVAL rszi.SzallIdoOra HOUR), DATE_ADD(DATE(NOW()), INTERVAL rszi.SzallIdoOra + 24 HOUR))
                    AS SzallIdo,
					k.SzabadMennyiseg AS Mennyiseg,
					r.Kod AS ForrasNev,
					r.Raktar_ID AS Raktar_ID,
					null AS AruforgBiz_ID,
					null AS AruforgBizTetel_ID,
					null AS AruforgBizValasz_ID,
					null AS AruforgBizValaszTetel_ID
				FROM keszlet k
				INNER JOIN raktar r ON r.Raktar_ID = k.Raktar_ID
				INNER JOIN raktar_szall_ido rszi ON rszi.ForrasRaktar_ID = r.Raktar_ID AND " . $warehouseCondition . '
				WHERE
					k.Termek_ID  IN (' . $productIDs . ") AND
					r.Kod IN ('" . $innerWarehouses . "') AND
					rszi.SzallIdoOra IS NOT NULL
			UNION
				SELECT
					'kulso_keszlet' AS Tipus,
					k.Termek_ID AS Termek_ID,
					IF(rszi.Hatarido >= TIME(NOW()),
                      DATE_ADD(DATE(NOW()),
                      INTERVAL rszi.SzallIdoOra HOUR), DATE_ADD(DATE(NOW()), INTERVAL rszi.SzallIdoOra + 24 HOUR))
                    AS SzallIdo,
					k.SzabadMennyiseg AS Mennyiseg,
					r.Kod AS ForrasNev,
					r.Raktar_ID AS Raktar_ID,
					null AS AruforgBiz_ID,
					null AS AruforgBizTetel_ID,
					null AS AruforgBizValasz_ID,
					null AS AruforgBizValaszTetel_ID
				FROM keszlet k
				INNER JOIN raktar r ON r.Raktar_ID = k.Raktar_ID
				INNER JOIN raktar_szall_ido rszi ON rszi.ForrasRaktar_ID = r.Raktar_ID AND " . $warehouseCondition . '
				WHERE
					k.Termek_ID  IN (' . $productIDs . ") AND
					r.Kod IN ('" . $externalWarehouses . "') AND
					rszi.SzallIdoOra IS NOT NULL
			UNION
				SELECT
					'beszerzes' AS Tipus,
					h.Termek_ID AS Termek_ID,
					h.SzallHatIdo AS SzallIdo,
					h.SzabadMennyiseg AS Mennyiseg,
					'' AS ForrasNev,
					h.Raktar_ID AS Raktar_ID,
					h.AruforgBiz_ID,
					h.AruforgBizTetel_ID,
					h.AruforgBizValasz_ID,
					h.AruforgBizValaszTetel_ID
				FROM szall_hatarido h
				WHERE
					h.Termek_ID IN (" . $productIDs . ') AND
					h.SzallHatIdo IS NOT NULL
		) AS a
		ORDER BY case when a.SzallIdo is null then 1 else 0 end, a.SzallIdo
		';

            $rows = DB::select($sql);

            $this->sources = [];

            foreach ($rows as $row) {
                if ($row->Tipus == 'keszlet') {
                    $stock = new Stock($row->Termek_ID, $row->SzallIdo, $row->Mennyiseg);
                    $stock->setWarehouseID($row->Raktar_ID);
                    $stock->setSourceName($row->ForrasNev);
                    $this->sources[$row->Termek_ID][] = $stock;
                } elseif ($row->Tipus == 'kulso_keszlet') {
                    $stock = new ExternalStock($row->Termek_ID, $row->SzallIdo, $row->Mennyiseg);
                    $stock->setWarehouseID($row->Raktar_ID);
                    $stock->setSourceName($row->ForrasNev);
                    $this->sources[$row->Termek_ID][] = $stock;
                } elseif ($row->Tipus == 'beszerzes') {
                    $supply = new Supply($row->Termek_ID, $row->SzallIdo, $row->Mennyiseg);
                    $supply->setWarehouseID($row->Raktar_ID);
                    $supply->setOrderID($row->AruforgBiz_ID);
                    $supply->setOrderItemID($row->AruforgBizTetel_ID);
                    $supply->setOrderResponseID($row->AruforgBizValasz_ID);
                    $supply->setOrderResponseItemID($row->AruforgBizValaszTetel_ID);
                    $supply->setSourceName($row->ForrasNev);
                    $this->sources[$row->Termek_ID][] = $supply;
                } elseif ($row->Tipus == 'gyartas') {
                    $manufacture = new Manufacture($row->Termek_ID, $row->SzallIdo);
                    $manufacture->setSourceName($row->ForrasNev);
                    $this->sources[$row->Termek_ID][] = $manufacture;
                }
            }
        }

        if (array_key_exists($productID, $this->sources)) {
            return $this->sources[$productID];
        }

        return [];
    }

    public function getSources($productID, $qty)
    {
        $sources = [];

        $allSources = $this->getAllSource($productID);

        if (! count($allSources)) {
            return [];
        }

        if ($this->shipping->is(Shipping::WHOLE)) {
            $allSources = array_reverse(array_slice($allSources, 0, $this->getLastIndex($productID, $qty) + 1));
        }

        foreach ($allSources as $source) {
            $sourceQty = $source->getQty();
            if ($sourceQty === null || $qty <= $sourceQty) {
                $source = clone $source;
                $source->setQty($qty);
                $sources[] = $source;
                if ($this->shipping->is(Shipping::WHOLE)) {
                    $sources = array_reverse($sources);
                }

                return $sources;
            }
            $qty -= $source->getQty();
            $sources[] = clone $source;
        }
        if ($this->shipping->is(Shipping::WHOLE)) {
            $sources = array_reverse($sources);
        }

        return $sources;
    }

    public function getDeliveryTime($productID, $qty)
    {
        if (! $this->isAdded($productID)) {
            $this->addProduct($productID);
        }
        $sources = $this->getAllSource($productID);
        $lastIndex = $this->getLastIndex($productID, $qty);

        if ($lastIndex !== null && array_key_exists($lastIndex, $sources)) {
            $source = $sources[$lastIndex];
            $deliveryTime = (new DeliveryTime($source->getDeliveryTime()))->getWorkDay();

            // Ha at kell szallitani masik raktarba, akkor aznap csak kesobb erheto el
            if (get_class($source) == Stock::class && $this->getWarehouse() && $this->getWarehouse()->Raktar_ID != $source->getWarehouseId()) {
                $deliveryTime->setTime('14:00');
            }

            return $deliveryTime;
        }

        return new DeliveryTime();
    }

    private function getLastIndex($productID, $qty)
    {
        $i = null;
        foreach ($this->getAllSource($productID) as $i => $source) {
            $sourceQty = $source->getQty();
            if ($sourceQty === null || $qty <= $sourceQty) {
                return $i;
            }
            $qty -= $sourceQty;
        }

        return $i;
    }
}
