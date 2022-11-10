<?php

use App\Libs\LUrl;

return [
    'faq' => 'GYIK',
    'faq_meta_description' => 'Összeszedtük a leggyakrabban feltett kérdéseket.',

    'intro' => 'Összeszedtük és megválaszoltuk neked a kollégáinkhoz feltett leggyakoribb kérdéseket a vásárlással, árukiszállítással, visszaküldéssel vagy a műszaki terméktámogatással kapcsolatban.',

    'question_1' => 'Nem jó árut rendeltem',
    'answer_1' => 'Amennyiben nem megfelelő terméket választottál és az nem egyedi rendelésre érkezett és nem projekttermék, úgy 30 napon belül visszaküldheted a sértetlen és bontatlan csomagolású terméket. A visszaküldés folyamatát <a href="https://files.riel.hu/kolcsonvisszarutermekek.pdf">itt</a> találod.',

    'question_2' => 'Nem tudok bejelentkezni az oldalra',
    'answer_2' => 'Bejelentkezéskor az oldal visszajelzi milyen okból nem tudsz bejelentkezni az oldalra.
					Ha az alábbiakban nem találsz megoldást a bejelentkezésre, keresd kollégáinkat.
					<ul>
						<li>
						<span class="font-semibold">Hibás jelszó</span>
							<div>Próbáld újra a helyes jelszóval vagy állíts be új jelszót az <a href="' . LUrl::route('password.request') . '">Elfelejtett jelszó</a> oldalon.!</div>
						</li>
						<li>
						<span class="font-semibold">Nincs ilyen felhasználói fiók</span>
							<div>Regisztrációd alkalmával tévesen adtad meg email címedet! <a href="' . LUrl::route('register') . '">Regisztrálj</a> újra a helyes email címmel!</div>
						</li>
					</ul>',

    'question_3' => 'Nem látok árakat és raktárkészletet',
    'answer_3' => 'Ha be tudsz jelentkezni az oldalra, de nem látsz árakat és nem látsz a raktárkészletet, azt jelenti, hogy fiókod még nem aktív.
					Ebben az esetben bejelentkezés után a <a href="' . LUrl::route('account.index') . '">Fiókod beállítások</a> menüpontban látod a fiókod státuszát.
					Az alábbi esetek fordulhatnak elő.
					<ul>
						<li>
						<span class="font-semibold">Nem hagytad jóvá email címed</span>
							<div>Kérj ismételten egy email cím megerősítő linket, ahol megerősítheted jelszavad. A megerősítés után kollégáink felülvizsgálják fiókodat és amennyiben a feltételeknek megfelelő üzleti partner vagy aktiválják fiókodat.</div>
						</li>
						<li>
						<span class="font-semibold">Fiók nem aktív</span>
							<div>Megerősítetted már email címedet, azonban kollégáink nem aktiválták még a fiókodat. Kérjük türelmedet, amennyiben a feltételeknek megfelelő üzleti partner vagy, kollégáink hamarosan aktiválják fiókodat.</div>
						</li>
					</ul>',

    'question_4' => 'Hogyan láthatom a javasolt telepítői árakat',
    'answer_4' => 'Amennyiben szerződött viszonteladónk vagy, a kollégáink általi a megfelelő beállítás elvégzése után elérhető lesz számodra az opció a <a href="' . LUrl::route('account.index') . '">Fiók beállítások</a> menüpontban, ahol a javasolt telepítői árakat bekapcsolhatod. Ebben az esetben a termékeknél az árak között láthatod a telepítői ár kijelzést is.',

    'question_5' => 'Hogyan vásárolhatok',
    'answer_5' => 'Ha céged megfelel az <a href="' . LUrl::route('terms') . '">ÁSZF</a> szerinti vásárlási követelményeknek, <a href="' . LUrl::route('register') . '">Regisztrálj</a> oldalunkon. A folyamat részeként meg kell erősítened jelszavadat, majd kollégáink aktiválják fiókodat. Ezt követően fogod látni árainkat, raktárkészletünket valamint ezzel egyidejűleg lesz elérhető számodra a kosár és a rendelés funkció.',
];
