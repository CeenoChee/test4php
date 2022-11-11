CREATE OR REPLACE VIEW view_termek_ugyfel_ar AS
SELECT
	t.Termek_ID,
	csff.CsopFizetesiFeltetel_ID,
    d.Deviza_ID,
    CASE
		WHEN ta.UgyfelAr IS NOT NULL THEN ta.UgyfelAr
        WHEN ta_huf.UgyfelAr IS NOT NULL THEN ta_huf.UgyfelAr / d.DevizaEladasiArfolyam
        WHEN d.Deviza_ID = 2 AND ta_eur.UgyfelAr IS NOT NULL THEN ta_eur.UgyfelAr / d_eur.DevizaVeteliArfolyam * d.DevizaEladasiArfolyam
        WHEN d.Deviza_ID = 5 AND ta_usd.UgyfelAr IS NOT NULL THEN ta_usd.UgyfelAr / d_usd.DevizaVeteliArfolyam * d.DevizaEladasiArfolyam
		ELSE null
    END UgyfelAr
FROM termek t
LEFT JOIN deviza d ON 1 = 1
LEFT JOIN csop_fizetesi_feltetel csff ON 1 = 1
LEFT JOIN termek_ugyfel_ar ta ON ta.Termek_ID = t.Termek_ID AND ta.CsopFizetesiFeltetel_ID = csff.CsopFizetesiFeltetel_ID AND ta.Deviza_ID = d.Deviza_ID
LEFT JOIN termek_ugyfel_ar ta_huf ON ta_huf.Termek_ID = t.Termek_ID AND ta_huf.CsopFizetesiFeltetel_ID = csff.CsopFizetesiFeltetel_ID AND ta_huf.Deviza_ID = 0
LEFT JOIN termek_ugyfel_ar ta_usd ON ta_usd.Termek_ID = t.Termek_ID AND ta_usd.CsopFizetesiFeltetel_ID = csff.CsopFizetesiFeltetel_ID AND ta_usd.Deviza_ID = 2
LEFT JOIN termek_ugyfel_ar ta_eur ON ta_eur.Termek_ID = t.Termek_ID AND ta_eur.CsopFizetesiFeltetel_ID = csff.CsopFizetesiFeltetel_ID AND ta_eur.Deviza_ID = 5
LEFT JOIN deviza d_usd ON d_usd.Deviza_ID = 2
LEFT JOIN deviza d_eur ON d_eur.Deviza_ID = 5
WHERE t.Aktiv = 1
