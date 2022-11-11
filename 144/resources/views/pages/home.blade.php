@extends('layouts.app')

@section('title')
    RIEL - @lang('pages/home.slogan')
@endsection

@section('structured_data')
    [{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "RIEL Elektronikai Kft.",
    "url": "https://www.riel.hu",
    "logo": "{{asset('/assets/images/riellogo.png')}}"
    },
    {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "url": "https://www.riel.hu/",
    "potentialAction": [{
    "@type": "SearchAction",
    "target": "https://www.riel.hu/termekek?kulcsszo={search_term_string}",
    "query-input": "required name=search_term_string"
    }]
    }]
@endsection

@section('top')
    <div class="pt-24 pb-10 bg-gradient-to-r from-sky-200 to-riel-light shadow-md">
        <div class="container mx-auto px-2 sm:px-5 md:px-5 lg:px-16 xl:px-32">
            @includeWhen($banner, 'includes.banner', ['banner' => $banner])
        </div>
    </div>
@endsection

@section('content')


    <div class="pt-16">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mb-32">
            @if ($cards->count())
                @foreach ($cards as $card)
                    @include('includes.card', ['card' => $card])
                @endforeach
            @endif
        </div>


        <div
            class="absolute bg-gradient-to-r from-riel-dark to-riel-light text-white w-full left-0 px-2 sm:px-5 md:px-5 lg:px-16 xl:px-32 py-8" id="choose-us-block">
            <div class="container mx-auto">

                <div class="mb-32 mt-16 mx-auto text-center w-full md:w-1/2 font-semibold text-base choose-us-title">
                    <h2 class="text-2xl mb-10">@lang('pages/home.choose_us_title')</h2>
                    @lang('pages/home.choose_us_text')
                </div>

                <div class="block grid grid-cols-1 sm:grid-cols-2 font-['Raleway','sans-serif']">

                    <div class="block md:flex text-center md:text-left mb-16 choose-us-item">
                        <div class="text-center md:text-left text-xl mb-5 md:mb-0"><i class="fal fa-puzzle-piece"></i>
                        </div>
                        <div class="px-5 md:pl-10">
                            <h3 class="text-2lg mb-5 uppercase font-semibold leading-none">
                                @lang('pages/home.choose_us_item_title_1')
                            </h3>
                            <div class="font-light text-base">
                                @lang('pages/home.choose_us_item_text_1')
                            </div>
                        </div>
                    </div>

                    <div class="block md:flex text-center md:text-right mb-16 choose-us-item">
                        <div class="text-center text-xl block md:hidden mb-5"><i class="fal fa-graduation-cap"></i>
                        </div>
                        <div class="px-5 md:pr-10">
                            <h3 class="text-2lg mb-5 uppercase font-semibold leading-none">
                                @lang('pages/home.choose_us_item_title_4')
                            </h3>
                            <div class="font-light text-base">
                                @lang('pages/home.choose_us_item_text_4')
                            </div>
                        </div>
                        <div class="text-xl hidden md:block"><i class="fal fa-graduation-cap"></i></div>
                    </div>

                    <div class="block md:flex text-center md:text-left mb-16 choose-us-item">
                        <div class="text-center md:text-left text-xl mb-5 md:mb-0"><i class="fal fa-cogs"></i></div>
                        <div class="px-5 md:pl-10">
                            <h3 class="text-2lg mb-5 uppercase font-semibold leading-none">
                                @lang('pages/home.choose_us_item_title_2')
                            </h3>
                            <div class="font-light text-base">
                                @lang('pages/home.choose_us_item_text_2')
                            </div>
                        </div>
                    </div>

                    <div class="block md:flex text-center md:text-right mb-16 choose-us-item">
                        <div class="text-center text-xl block md:hidden mb-5"><i class="fal fa-tachometer"></i></div>
                        <div class="px-5 md:pr-10">
                            <h3 class="text-2lg mb-5 uppercase font-semibold leading-none">
                                @lang('pages/home.choose_us_item_title_5')
                            </h3>
                            <div class="font-light text-base">
                                @lang('pages/home.choose_us_item_text_5')
                            </div>
                        </div>
                        <div class="text-xl hidden md:block"><i class="fal fa-tachometer"></i></div>
                    </div>

                    <div class="block md:flex text-center md:text-left mb-16 choose-us-item">
                        <div class="text-center md:text-left text-xl mb-5 md:mb-0"><i class="fal fa-wrench"></i></div>
                        <div class="px-5 md:pl-10">
                            <h3 class="text-2lg mb-5 uppercase font-semibold leading-none">
                                @lang('pages/home.choose_us_item_title_3')
                            </h3>
                            <div class="font-light text-base">
                                @lang('pages/home.choose_us_item_text_3')
                            </div>
                        </div>
                    </div>


                    <div class="block md:flex text-center md:text-right mb-16 choose-us-item">
                        <div class="text-center text-xl block md:hidden mb-5"><i class="fal fa-truck"></i></div>
                        <div class="px-5 md:pr-10">
                            <h3 class="text-2lg mb-5 uppercase font-semibold leading-none">
                                @lang('pages/home.choose_us_item_title_6')
                            </h3>
                            <div class="font-light text-base">
                                @lang('pages/home.choose_us_item_text_6')
                            </div>
                        </div>
                        <div class="text-xl hidden md:block"><i class="fal fa-truck"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4 mt-[2350px] 2xs:mt-[2150px] xs:mt-[1900px] sm:mt-[1400px] md:mt-[1300px] lg:mt-[1200px] xl:mt-[1100px] ">
            @if ($manufacturers->count())
                @foreach ($manufacturers as $manufacturer)
                    @include('includes.manufacturer', ['manufacturer' => $manufacturer])
                @endforeach
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            $(".banner").css({'opacity':'0', 'right': '50px', 'position': 'relative'}).animate({'opacity':'1','right':'0px'}, 700);

            $(".home-card").each(function (index) {
                $(this).delay(400 * index).css({'display':'block', 'opacity':'0', 'top': '-5%', 'position': 'relative'}).animate({'opacity':'1','top':'5%'}, 700);
            });


            let chooseUsBlock = $('#choose-us-block');
            let boxTop = chooseUsBlock.offset().top - 600;
            let items = $(".choose-us-item");
            let chooseUsTitle = $(".choose-us-title");

            if(window.innerWidth > 768){
                items.css({'opacity':'0', 'position': 'relative'});
                items.odd().css({'left': '50px'});
                items.even().css({'right': '50px'});
                chooseUsTitle.css({'opacity': '0'});
            }


            $(document).scroll(function () {
                if (!chooseUsBlock.hasClass('loaded') && (document.body.scrollTop > boxTop || document.documentElement.scrollTop > boxTop)) {

                    chooseUsTitle.animate({'opacity':'1'}, 800).delay(400);

                    $(".choose-us-item").each(function (index) {
                        if(index % 2 == 0){
                            $(this).delay(400 * index).animate({'opacity':'1','right':'0px'}, 700);
                        }else{
                            $(this).delay(400 * index).animate({'opacity':'1','left':'0px'}, 700);
                        }

                    });
                    chooseUsBlock.addClass('loaded');
                }
            });


        });
    </script>
@endpush

