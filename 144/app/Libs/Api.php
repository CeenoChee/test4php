<?php

namespace App\Libs;

use App\Models\Customer;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\DB;

class Api
{
    private Customer $customer;

    public function __construct(Customer $customer)
    {
        set_time_limit(0);
        $this->customer = $customer;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getProductsData(): array
    {
        $relatedQuery = '
			SELECT tkt.Termek_ID, t.Kod AS Kod
			FROM termek_kiegeszitotermek tkt
			INNER JOIN termek t ON t.Termek_ID = tkt.KiegeszitoTermek_ID
		';

        $assoc = [];
        foreach (DB::select($relatedQuery) as $row) {
            $assoc[$row->Termek_ID][] = $row->Kod;
        }

        $blacklistedManufacturerIds = (new Manufacturer())->getBlacklistedIds($this->customer->Ugyfel_ID);

        $sql = "
			SELECT
				t.Termek_ID,
				t.Kod,
				t.Nev,
			    tf.Leiras,
				gy.Nev AS Gyarto,
				ta.ListaAr AS ListaAr,
				ta.AkciosAr AS AkciosAr,
				tua.UgyfelAr AS UgyfelAr,
				tar.UgyfelAr AS TelepitoiAr,
				IFNULL(keszlet.SzabadMennyiseg, 0) AS Keszlet,
				t.Projekt AS Projekt,
				t.ItTermek AS ItTermek,
				IFNULL((SELECT m.file_name
                        FROM media_model mm
                        LEFT JOIN media m ON m.id = mm.media_id
                        WHERE  mm.model_id = t.Termek_ID and m.collection_name = 'image' AND mm.model_type = 'Termek'
                        ORDER BY sort
			            LIMIT 1), '') AS Kep,
				IFNULL((SELECT m.file_name
                        FROM media_model mm
                        LEFT JOIN media m ON m.id = mm.media_id
                        WHERE  mm.model_id = t.Termek_ID and m.collection_name = 'datasheet' AND mm.model_type = 'Termek'
                        ORDER BY sort
			            LIMIT 1), '') AS Adatlap,
				ttf2.TermekfaLevel_ID,
				t.Kifuto,
				t.Ujdonsag
			FROM termek t
			LEFT JOIN termek_forditas tf ON tf.Termek_ID = t.Termek_ID
			LEFT JOIN manufacturers gy ON gy.Gyarto_ID = t.Gyarto_ID
			LEFT JOIN termek_ar ta ON ta.Termek_ID = t.Termek_ID AND ta.Deviza_ID = ?
			LEFT JOIN termek_ugyfel_ar tua ON tua.Termek_ID = t.Termek_ID AND tua.Deviza_ID = ? AND tua.CsopFizetesiFeltetel_ID = ?
			LEFT JOIN termek_ugyfel_ar tar ON tar.Termek_ID = t.Termek_ID AND tar.Deviza_ID = ? AND tar.CsopFizetesiFeltetel_ID = 4
			LEFT JOIN (
				SELECT k.Termek_ID, SUM(k.SzabadMennyiseg) AS SzabadMennyiseg
				FROM keszlet k
				INNER JOIN raktar r ON r.Raktar_ID = k.Raktar_ID
				WHERE r.Kod IN ('" . implode("','", config('riel.warehouse.inner')) . "')
				GROUP BY k.Termek_ID
			) AS keszlet ON keszlet.Termek_ID = t.Termek_ID
			LEFT JOIN (
				SELECT ttf.Termek_ID, MIN(ttf.TermekfaLevel_ID) AS TermekfaLevel_ID
				FROM termek_termekfa ttf
				GROUP BY ttf.Termek_ID
			) AS ttf2 ON ttf2.Termek_ID = t.Termek_ID
			WHERE t.Aktiv = 1
			AND tf.Nyelv_ID = 0
			AND gy.Gyarto_ID NOT IN (" . ($blacklistedManufacturerIds->count() ? $blacklistedManufacturerIds->implode(',') : -1) . ')
		';

        ProductAttributeList::preloadAll();

        $category = app('Category');

        $rows = DB::select($sql, [
            $this->customer->Deviza_ID,
            $this->customer->Deviza_ID,
            $this->customer->CsopFizetesiFeltetel_ID,
            $this->customer->Deviza_ID,
        ]);

        $reseller = $this->isInstaller();
        $isRiel = $this->isRiel();

        $attributeLists = [];
        foreach ($rows as $row) {
            $attributeLists[$row->Termek_ID] = new ProductAttributeList($row->Termek_ID);
        }

        $data = [];
        foreach ($rows as $row) {
            $datarow = [
                'ProductCode' => $row->Kod,
                'Description' => $row->Nev,
                'Tags' => (string) $attributeLists[$row->Termek_ID],
                'Manufacturer' => $row->Gyarto,
                'ListPrice' => $this->price($row->ListaAr),
                'PartnerPrice' => $this->price($row->UgyfelAr),
                'SalePrice' => $row->AkciosAr ? $this->price($row->AkciosAr) : '',
                'ProjectProduct' => ($row->Projekt ? 'IGEN' : ''),
                'Stock' => ($isRiel or $row->Keszlet <= 20) ? (int) $row->Keszlet : '20+',
                'Image' => $row->Kep ? Fct::getMediaImageUrl($row->Kep, 'product-big') : '',
                'DataSheet' => $row->Adatlap ? Fct::getMediaFileUrl($row->Adatlap) : '',
                'Category' => $category->getFullName($row->TermekfaLevel_ID),
                'Accessories' => array_key_exists($row->Termek_ID, $assoc) ? implode(';', $assoc[$row->Termek_ID]) : '',
                'Status' => ($row->Kifuto ? ($row->Keszlet > 0 ? 'Kifutó' : 'Kifutott') : ($row->Ujdonsag ? 'Újdonság' : 'Normál')),
                'Comment' => strip_tags($row->Leiras),
            ];

            if ($reseller) {
                $datarow['InstallerPrice'] = $this->price($row->TelepitoiAr);
            }

            $data[] = $datarow;
        }

        return $data;
    }

    public function isInstaller(): bool
    {
        return (bool) $this->customer->Viszontelado;
    }

    public function isRiel(): bool
    {
        return $this->customer->Ugyfel_ID == 1074;
    }

    private function price($price): int
    {
        return (int) $price;
    }
}
