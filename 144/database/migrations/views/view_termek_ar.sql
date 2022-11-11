CREATE OR REPLACE VIEW view_termek_ar AS
SELECT
	t.Termek_ID,
    d.Deviza_ID,
    ta.AkciosAr_ID,
    CASE
		WHEN ta.ListaAr IS NOT NULL THEN ta.ListaAr
        WHEN ta_huf.ListaAr IS NOT NULL THEN ta_huf.ListaAr / d.DevizaEladasiArfolyam
        WHEN d.Deviza_ID = 2 AND ta_eur.ListaAr IS NOT NULL THEN ta_eur.ListaAr / d_eur.DevizaVeteliArfolyam * d.DevizaEladasiArfolyam
        WHEN d.Deviza_ID = 5 AND ta_usd.ListaAr IS NOT NULL THEN ta_usd.ListaAr / d_usd.DevizaVeteliArfolyam * d.DevizaEladasiArfolyam
		ELSE null
    END ListaAr,
    CASE
		WHEN ta.AkciosAr IS NOT NULL THEN ta.AkciosAr
        WHEN ta_huf.AkciosAr IS NOT NULL THEN ta_huf.AkciosAr / d.DevizaEladasiArfolyam
        WHEN d.Deviza_ID = 2 AND ta_eur.AkciosAr IS NOT NULL THEN ta_eur.AkciosAr / d_eur.DevizaVeteliArfolyam * d.DevizaEladasiArfolyam
        WHEN d.Deviza_ID = 5 AND ta_usd.AkciosAr IS NOT NULL THEN ta_usd.AkciosAr / d_usd.DevizaVeteliArfolyam * d.DevizaEladasiArfolyam
		ELSE null
    END AkciosAr,
    IFNULL(ta_huf.AkcioNev, IFNULL(ta_eur.AkcioNev, IFNULL(ta_usd.AkcioNev, ta.AkcioNev))) AS AkcioNev
FROM termek t
LEFT JOIN deviza d ON 1 = 1
LEFT JOIN termek_ar ta ON ta.Termek_ID = t.Termek_ID AND ta.Deviza_ID = d.Deviza_ID
LEFT JOIN termek_ar ta_huf ON ta_huf.Termek_ID = t.Termek_ID AND ta_huf.Deviza_ID = 0
LEFT JOIN termek_ar ta_usd ON ta_usd.Termek_ID = t.Termek_ID AND ta_usd.Deviza_ID = 2
LEFT JOIN termek_ar ta_eur ON ta_eur.Termek_ID = t.Termek_ID AND ta_eur.Deviza_ID = 5
LEFT JOIN deviza d_usd ON d_usd.Deviza_ID = 2
LEFT JOIN deviza d_eur ON d_eur.Deviza_ID = 5
WHERE t.Aktiv = 1
