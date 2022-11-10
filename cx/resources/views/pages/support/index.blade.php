@extends('layouts.app')

@section('title')
    @lang('pages/supports.support')
@endsection

@section('content_title')
    @lang('pages/supports.support')
@endsection

@section('meta_description')
    @lang('pages/supports.support_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('support') }}
@endsection

@section('top')
    @include('pages.support.includes.search-form')
@endsection

@section('content')

    <div class="flex gap-10 my-10">

        <div class="md:basis-2/3 md:border-r border-neutral-200">

            <div class="text-3xl font-thin mb-6">
                <a href="{{ LUrl::route('knowledge.index') }}" class="text-inherit">
                    <i class="fal mr-1 fa-books"></i> @lang('pages/knowledge.knowledge')
                </a>
            </div>

            <div class="mb-10 pr-10">
                A tudástár bejegyzéseink között megtalálod az általunk forgalmazott eszközökhöz készült útmutatóinkat,
                telepítői leírásainkat.
                Számos kategóriában böngészhetsz a számodra megfelelő témák között. A kereső segítségével könnyedén
                megtalálhatod a kívánt útmutatókat.
                Ha a tudástár egyik cikkében sem találtad meg a választ, bátran keress fel minket!
            </div>

            <a href="{{ LUrl::route('knowledge.index') }}"
               class="py-2 px-4 border border-riel-light text-riel-light rounded-md hover:text-white hover:bg-riel-light">
                @lang('pages/supports.go_to_knowledge')
            </a>

        </div>

        <div class="basis-1/3 md:block hidden">
            <div class="grid grid-cols-2 grid-rows-2">
                @foreach($knowledgeCategories as $category)
                    <div class="mb-4">
                        <a href="{{ LUrl::route('knowledge.category', ['slug' => $category->translation->slug]) }}" class="text-inherit">
                            <div class="text-center">
                                @if($category->media->first())
                                    <img src="{{$category->media->first()->getFilesUrl() }}"
                                        class="mx-auto rounded-md h-[100px]"/>
                                @endif
                            </div>
                            <div class="font-bold mt-2 text-center">
                                {{ $category->translation->name}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>


    <div class="flex gap-10 bg-neutral-200 rounded-md p-3 my-10">


        <div class="basis-1/3 md:block hidden">
            <div class="grid grid-cols-2 grid-rows-2">
                @foreach($downloadCategories as $downloadCategory)
                    <div class="my-6">
                        <a class="text-inherit" href="{{  LUrl::route('download.categories.show', ['downloadCategorySlug' => $downloadCategory->translation->slug]) }}">
                            <div class="text-center">
                                @if($downloadCategory->media->first())
                                    <img src="{{$downloadCategory->media->first()->getFilesUrl() }}" class="mx-auto rounded-md h-[100px]"/>
                                @endif
                            </div>
                            <div class="font-bold mt-2 text-center">
                                {{ $downloadCategory->translation->name }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="md:basis-2/3 md:border-l border-gray-400 md:text-right">

            <div class="text-3xl font-thin mb-6">
                <a class="text-inherit" href="{{ LUrl::route('download.categories.index') }}">
                    <i class="fal mr-1 fa-download"></i> @lang('pages/downloads.downloads')
                </a>
            </div>

            <div class="mb-10 md:pl-10">
                Letöltéseink között megtalálod az általunk forgalmazott eszközökhöz készült szoftvereket, kliens oldali
                programokat és útmutatókat.
                Honlapunk kizárólag megbízható forrásból származó, biztonságos szoftvereket tartalmaz, így bátran
                letöltheted és telepítheted őket.
                Ha nem találod meg a számodra alkalmas programot, ne habozz felkeresni minket és mi mindent megteszünk,
                hogy segítsünk Neked!
            </div>

            <a href="{{ LUrl::route('download.categories.index') }}"
               class="py-2 px-4 border border-riel-light text-riel-light rounded-md hover:text-white hover:bg-riel-light">
                @lang('pages/supports.go_to_downloads')
            </a>

        </div>
    </div>


    <div class="py-6 my-10">
        <div class="text-3xl font-thin mb-6 text-center">
            <a class="text-inherit" href="{{ LUrl::route('videos.index') }}">
                <i class="fal mr-1 fa-circle-play"></i> @lang('pages/videos.videos')
            </a>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-4 mb-10">
            @foreach($videos as $video)
                <a class="text-inherit" target="_blank" href="{{$video->url}}">
                    <div>
                        <img class="mx-auto md:mx-0" src="{{ $video->image }}">
                    </div>

                    <h4 class="font-bold text-xs my-3 text-center md:text-left">{{ $video->title }}</h4>
                </a>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ LUrl::route('videos.index') }}"
               class="py-2 px-4 border border-riel-light text-riel-light rounded-md hover:text-white hover:bg-riel-light">
                @lang('pages/supports.go_to_videos')
            </a>
        </div>
    </div>



    <div class="grid md:grid-cols-2 md:grid-rows-2 my-10 border-2 border-neutral-200 rounded-md">

        <div class="text-center py-8 bg-neutral-200">

            <i class="fa fa-inbox-in rounded-full shadow-xl border-2 p-8 text-3xl text-riel-dark border-riel-light"></i>
            <a href="{{ LUrl::route('ticket') }}"
               class="text-2lg mt-4 mb-6 block font-bold text-riel-dark hover:text-sky-700">
                @lang('pages/tickets.tickets')
            </a>

            <ul class="text-left font-thin text-lg w-fit mx-auto">
                <li>
                    <i class="fa fa-check text-green-500"></i> Azonnali segítség
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Bármilyen műszaki kérdés
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Szoftver konfigurálás
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Hibajegykezelő rendszer
                </li>
                <li class="pl-5">
                    <a href="{{ LUrl::route('ticket') }}" class="text-sm mt-2 text-riel-light font-semibold">Tovább</a>
                </li>
            </ul>
        </div>

        <div class="text-center py-8 border-b-2 border-neutral-200 md:border-0">
            <i class="fa fa-comment-question shadow-xl rounded-full border-2 p-8 text-3xl text-riel-dark border-riel-light"></i>
            <a href="{{ LUrl::route('faq') }}"
               class="text-2lg mt-4 mb-6 block font-bold text-riel-dark hover:text-sky-700">
                @lang('pages/faq.faq')
            </a>

            <ul class="text-left font-thin text-lg w-fit mx-auto">
                <li>
                    <i class="fa fa-check text-green-500"></i> Nem jó árut rendeltél?
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Hogyan vásárolhatsz?
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Hogyan láthatod az árakat?
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Nem tudsz bejelentkezni?
                </li>
                <li class="pl-5">
                    <a href="{{ LUrl::route('faq') }}" class="text-sm mt-2 text-riel-light font-semibold">Tovább</a>
                </li>
            </ul>
        </div>
        <div class="text-center py-8">
            <i class="fa fa-shield-check shadow-xl rounded-full border-2 p-8 text-3xl text-riel-dark border-riel-light"></i>
            <a href="{{ LUrl::route('warranty') }}"
               class="text-2lg mt-4 mb-6 block font-bold text-riel-dark hover:text-sky-700">
                @lang('pages/warranties.warranty')
            </a>

            <ul class="text-left font-thin text-lg w-[300px] md:w-fit mx-auto">
                <li>
                    <i class="fa fa-check text-green-500"></i> Garancia folyamat
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Mire nem vonatkozik a garancia?
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Garancia vállalás márkánként részletezve
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Minimum 1 év garancia vállalás
                </li>
                <li class="pl-5">
                    <a href="{{ LUrl::route('warranty') }}" class="text-sm mt-2 text-riel-light font-semibold">Tovább</a>
                </li>
            </ul>

        </div>
        <div class="text-center py-8 bg-neutral-200">
            <i class="fa fa-microchip shadow-xl rounded-full border-2 p-8 text-3xl text-riel-dark border-riel-light"></i>
            <a href="{{ LUrl::route('repair') }}"
               class="text-2lg mt-4 mb-6 block font-bold text-riel-dark hover:text-sky-700">
                @lang('pages/services.repair')
            </a>

            <ul class="text-left font-thin text-lg w-fit mx-auto">
                <li>
                    <i class="fa fa-check text-green-500"></i> Márkafüggetlen szerviz
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Szerviz űrlap
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Garanciális javítás menete
                </li>
                <li>
                    <i class="fa fa-check text-green-500"></i> Részletes leírás lépésenként
                </li>
                <li class="pl-5">
                    <a href="{{ LUrl::route('repair') }}" class="text-sm mt-2 text-riel-light font-semibold">Tovább</a>
                </li>
            </ul>
        </div>

    </div>



@endsection

@section('bottom')
    <div class="bg-gradient-to-r from-riel-dark to-riel-light p-16">

        <div class="container mx-auto">

            <h2 class="text-center text-2xl fon mb-20 text-white">
                @lang('pages/contact.contact')
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-12">

                <div class="text-center flex flex-col">

                    <div class="grow">
                        <i class="fa fa-inbox-in text-sky-800 text-xl mb-4 "></i>

                        <h3 class="text-2lg mb-4 text-cyan-300">
                            @lang('pages/supports.written')
                        </h3>

                        <div class="uppercase mb-2 text-xs text-sky-900">
                            @lang('pages/supports.writing_1')
                        </div>

                        <div class="mb-4 mx-auto text-cyan-200">
                            @lang('pages/supports.writing_2')
                        </div>
                    </div>
                    <div class="justify-center flex">
                        <a href="mailto:support@riel.hu"
                           class="py-2 px-4 bg-gradient-to-r from-cyan-500 to-sky-500 text-white font-bold hover:text-white rounded-md w-fit hover:to-sky-400">
                            support@riel.hu
                        </a>
                    </div>

                </div>


                <div class="text-center flex flex-col">

                    <div class="grow">
                        <i class="fa fa-phone text-sky-800 text-xl mb-4"></i>

                        <h3 class="text-2lg mb-4 text-cyan-300">
                            @lang('pages/supports.on_the_phone')
                        </h3>

                        <div class="uppercase mb-2 text-xs text-sky-900">
                            @lang('pages/supports.phone_1')
                        </div>

                        <div class="mb-4 mx-auto text-cyan-200">
                            @lang('pages/supports.phone_2')
                        </div>

                    </div>

                    <div class="justify-center flex gap-4">
                        <a href="tel:+3612368092"
                           class="py-2 px-4 bg-gradient-to-r from-cyan-500 to-sky-500 text-white font-bold hover:text-white rounded-md w-fit  hover:to-sky-400 ">
                            +36 (1) 236 8092
                        </a>

                        <a href="tel:+36208900702"
                           class="py-2 px-4 bg-gradient-to-r from-cyan-500 to-sky-500 text-white font-bold hover:text-white rounded-md w-fit hover:to-sky-400 ">
                            +36 (20) 890 0702
                        </a>
                    </div>

                </div>

                <div class="text-center flex flex-col">

                    <div class="grow">

                        <i class="fa fa-map-marker-alt text-sky-800 text-xl mb-4"></i>

                        <h3 class="text-2lg mb-4 text-cyan-300">
                            @lang('pages/supports.personally')
                        </h3>

                        <div class="uppercase mb-2 text-xs text-sky-900">
                            @lang('pages/supports.personally_1')
                        </div>

                        <div class="mb-4 mx-auto text-cyan-200">
                            @lang('pages/supports.personally_2')
                        </div>
                    </div>

                    <div class="justify-center flex">
                        <a target="_blank"
                           href="https://www.google.hu/maps/dir//Budapest,+Frangep%C3%A1n+u.+23,+1139/@47.5353025,19.0723343,17z/data=!4m16!1m7!3m6!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2sBudapest,+Frangep%C3%A1n+u.+23,+1139!3b1!8m2!3d47.5353025!4d19.074523!4m7!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025"
                           class="py-2 px-4 bg-gradient-to-r from-cyan-500 to-sky-500 text-white font-bold hover:text-white rounded-md w-fit hover:to-sky-400">
                            Budapest 1139, Frangepán u. 23.
                        </a>
                    </div>


                </div>

                <div class="text-center">

                    <i class="fa fa-user-hard-hat text-sky-800 text-xl mb-4"></i>

                    <h3 class="text-2lg mb-4 text-cyan-300">
                        @lang('pages/supports.personally')
                    </h3>

                    <div class="uppercase mb-2 text-xs text-sky-900">
                        @lang('pages/supports.personally_3')
                    </div>

                    <div class="mb-4 mx-auto text-cyan-200">
                        @lang('pages/supports.personally_4')
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

