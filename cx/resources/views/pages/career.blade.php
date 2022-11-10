@extends('layouts.app')

@section('title')
    @lang('pages/career.career')
@endsection

@section('content_title')
    @lang('pages/career.career')
@endsection

@section('meta_description')
    @lang('pages/career.career_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('career') }}
@endsection

@section('content')

    <article class="text-justify">

        <x-card class="mb-8">
            <h2 class="font-bold mb-5 text-lg">CÉGÜNK</h2>
            <p class="mb-5">
                A RIEL magyar tulajdonú középvállalatként 30 éve a biztonságtechnikai szektor meghatározó szereplője. Fő
                tevékenységként világvezető gyártók biztonságtechnikai rendszereinek forgalmazásával foglalkozunk,
                emellett kiemelkedő műszaki terméktámogatást és profi márkafüggetlen szervizszolgáltatást kínálunk
                partnereinknek.
            </p>
        </x-card>

        <x-card class="my-8">
            <h2 class="text-xl text-center uppercase mb-10">KERESKEDELMI ASSZISZTENS</h2>
            <p class="mb-5">
                Kereskedelmi csapatunkba keressük munkatársunk, aki Kereskedelmi asszisztens pozícióban csatlakozna hozzánk! Kereskedelmi asszisztensként cégünk értékesítési- és beszerzési folyamatait tudod segíteni. A rád váró feladatok közé tartozik majd az árajánlatok, rendelések és szerződések előkészítése, iktatása. Projektek regisztrációja és nyomon követése, gyártókkal egyeztetés. Valamint az ügyviteli rendszerünkben adminisztratív feladatok elvégzése.
            </p>
            <p class="mb-5">
                Olyan jelöltet keresünk, aki jó kapcsolatteremtő készséggel rendelkezik. Felelősségtudat, elhivatottság és precizitás jellemzi munkavégzését. Fontos, hogy legyen legalább 2 év hasonló munkakörben szerzett tapasztalatod valamint angolul társalgási képes szinten tudj kommunikálni.
            </p>
            <p class="mb-5">
                A pozíció részletes leírásáért kattints a <a class="text-riel-light" href="https://www.profession.hu/allas/1964889"
                                                             rel="nofollow" target="_blank"
                >https://www.profession.hu/allas/1964889</a> weboldalra és küldd el a jelentkezésedet az <a
                    href="mailto:allas@riel.hu?subject=Kereskedelmi asszisztens"
                >allas@riel.hu</a> címre.
            </p>
        </x-card>

        <x-card class="my-8">
            <h2 class="text-xl text-center uppercase mb-10">RAKTÁROS</h2>
            <p class="mb-5">
                Raktáros komissiózó kollégát keresünk gépi és kézi anyagmozgatási, készletezési, dokumentálási feladatok ellátására dunakeszi raktárunkba. Egy műszakos munkarendben kínálunk hosszú távú munkalehetőséget, cafetéria rendszert, nyelvtanulási lehetőséget.
            </p>
            <p class="mb-5">További részletekért kattints ide: <a class="text-riel-light" href="https://files.riel.hu/media/raktaros_hir-623c84fd11d41.pdf" target="_blank">Raktáros pozíció részletei</a></p>
            <p class="mb-5">
                A pozíció részletes leírásáért kattints a <a class="text-riel-light" href="https://www.profession.hu/allas/1961613"
                                                             rel="nofollow" target="_blank"
                >https://www.profession.hu/allas/1961613</a> weboldalra és küldd el a jelentkezésedet az <a
                    class="text-riel-light"
                    href="mailto:allas@riel.hu?subject=Raktáros jelentkezés"
                >allas@riel.hu</a> címre.
            </p>
        </x-card>

        <x-card class="my-8">
            <h2 class="text-xl text-center uppercase mb-10">Junior biztonságtechnikai rendszermérnök</h2>

            <p class="mb-5">
                Biztonságtechnikai rendszermérnökként nálunk betekintést nyerhetsz a szakma szépségeibe. Elsőként
                veheted kezedbe és tesztelheted a piacon megjelent újdonságokat. Az ország legösszetettebb videó-,
                riasztó-, beléptető- és felügyeleti rendszereinél vehetsz részt a tervezésben, beüzemelésben és műszaki
                támogatásban.
                Téged keresünk, ha kitartó vagy, szeretsz tanulni, meg tudod oldani a műszaki problémákat, érdekel is a
                biztonságtechnika és szereted gyakorlatban kipróbálni az ismereteidet.
            </p>
            <p class="mb-5">
                Fontos, hogy gyakorlatban is tudd, miből áll össze és hogyan működik egy biztonságtechnikai rendszer
                (CCTV, beléptető, behatolásjelző), hogy be tudj állítani egy routert, hogy feladataid megoldásához fel
                tudd kutatni és fel tudd dolgozni az angolul elérhető információkat.
            </p>
            <p class="mb-5">
                Amit kínálunk: munkához használatos notebook és mobiltelefon; korszerű környezetben végezheted a
                kihívásokkal teli, változatos munkádat; versenyképes alapbér mellett cafeteria rendszer; rendszeres
                szakmai képzések; angol és német nyelvtanulás lehetősége; barátságos, közvetlen, fiatalos csapat;
                stabil, hosszútávú álláslehetőség; változatos, sokrétű feladatkör; tömegközlekedéssel és kerékpárral
                könnyen megközelíthető iroda; saját ebédlő tetőterasszal; home office lehetőség.
            </p>
            <p class="mb-5">
                Jelentkezésedet az <a class="text-riel-light"
                                      href="mailto:allas@riel.hu?subject=Junior biztonságtechnikai mérnök jelentkezés"
                >allas@riel.hu</a>
                címre küldött levélben várjuk.
            </p>
        </x-card>

        <x-card class="my-8">
            <h2 class="text-xl text-center uppercase mb-10">SZERVIZTECHNIKUS</h2>
            <p class="mb-5">
                Bővülő szervizcsapatunkba keresünk műszerész tapasztalattal vagy technikusi tapasztalattal rendelkező munkatársat. Szervizünkben három üzletágunk (biztonságtechnika, biztonsági ellenőrzések, ipari megoldások) termékeinek garanciális és garancián túli javításait végezzük, továbbá mindenféle biztonságtechnikai eszköz szervizelésével foglalkozunk.
            </p>
            <p class="mb-5">
                A műszaki tapasztalat mellett középszintű angol nyelvtudást kérünk szóban és írásban, valamint B kategóriás jogosítványt és esetenkénti utazási hajlandóságot (aktív vezetési tapasztalattal).
            </p>
            <p class="mb-5">
                Jelentkezésedet az <a class="text-riel-light"  href="mailto:allas@riel.hu?subject=Szerviztechnikus jelentkezés"
                >allas@riel.hu</a> címre küldött levélben várjuk.
            </p>
        </x-card>

        <x-card class="my-8">
            <h2 class="text-xl text-center uppercase mb-10">PROJEKTTÁMOGATÓ MÉRNÖK – IPARI MEGOLDÁSOK ÜZLETÁG</h2>
            <p class="mb-5">
                Ipari megoldások üzletágunk mérnökcsapatába keresünk projekttámogató mérnököt, aki az ipari képfeldolgozás hagyományos és intelligens kamerarendszerekkel, adatgyűjtő rendszerekkel és gyorskamerákkal kapcsolatos feladatatait támogatja. A megoldások ügyfélnél történő bemutatása, folyamatok modellezése és tesztelése, valamint az ajánlattételi feladatoktól kezdve a projektek műszaki előkészítése és lebonyolítása mind a munkakör részeit képzik. Ha van tapasztalatod méréstechnikában vagy gyártásban, emellett ipari képalkotásban vagy fotózásban, akkor nálunk egy gyorsan fejlődő, elkötelezett, vidám és fiatal csapat tagja lehetsz.
            </p>
            <p class="mb-5">
                A munkához villamosmérnöki, gépészmérnöki vagy mechatronikai mérnöki végzettség, legalább 3 év mérnöki tapasztalat szükséges méréstechnika vagy gyártás területén, kell jó kapcsolatteremtő- és konfliktuskezelő képesség, folyékony angol nyelvtudás szóban és írásban, valamint B kategóriás jogosítvány és utazási hajlandóság (aktív vezetési tapasztalattal).
            </p>
            <p class="mb-5">
                A pozíció részletes leírásáért kattints a <a class="text-riel-light" href="https://www.profession.hu/allas/1947835"
                                                             rel="nofollow" target="_blank"
                >https://www.profession.hu/allas/1947835</a> weboldalra és küldd el a jelentkezésedet az <a
                    class="text-riel-light"
                    href="mailto:allas@riel.hu?subject=Projekttámogató mérnök jelentkezés"
                >allas@riel.hu</a> címre.
            </p>
        </x-card>

        <x-card class="my-8">
            <h2 class="text-xl text-center uppercase mb-10">CIKKTÖRZS-KARBANTARTÓ</h2>
            <p class="mb-5">
                Keressük új kollégánkat cikktörzs-karbantartó pozícióba. Feladataid a rád bízott márkák teljes termékportfóliójának gondozása és naprakészen tartása ERP és belső adminisztrációs rendszereinkben, cikktörzs karbantartása (cikkek felvétele, változások kezelése, helyettesítő, kiegészítő és kapcsolódó termékek beállítása, cikkek kifuttatása, árazási feladatok adminisztrálása: árak frissítése és korrigálása, akciós árak beállítása.
            </p>
            <p class="mb-5">
                Téged keresünk, ha minimum középfokú a végzettséged, de nagy pluszt jelenthet, ha releváns mérnöki vagy gazdasági tanulmányokkal és/vagy munkatapasztalattal rendelkezel a fenti feladatokkal kapcsolatban elsődlegesen biztonságtechnikai területen. Elvárás, hogy otthonosan mozogj az Excel táblák és azok képletei között és használtál már valamilyen vállalatirányítási rendszert, valamint, hogy angol nyelvtudásod legalább alap szintű és aktívan is tartod.
            </p>
            <p class="mb-5">
                Jelentkezésedet az <a class="text-riel-light" href="mailto:allas@riel.hu?subject=Cikktörzs-karbantartó jelentkezés"
                >allas@riel.hu</a> címre küldött levélben várjuk.
            </p>
        </x-card>
    </article>
@endsection
