@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/comparison.css') }}" rel="stylesheet">
@endsection

@section('title')
    @lang('pages/comparison.compare')
@endsection

@section('content_title')
    @lang('pages/comparison.compare')
@endsection

@section('meta_description')
    @lang('pages/comparison.compare_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('comparison') }}
@endsection


@section('top')
    <div id="comparison-page">


        @if($products->count() > 0)
            <section class="cd-products-comparison-table">
                <header class="mt-10">
                    <div class="actions">
                        <a href="#0" class="reset hidden">@lang('pages/products.reset_filter')</a>
                        <a href="#0" class="filter">@lang('pages/products.filter')</a>
                    </div>
                </header>

                <div class="cd-products-table">
                    <div class="features">
                        <div class="top-info">@lang('pages/products.products')</div>
                        <ul class="cd-features-list">
                            @foreach($allProperties as $innerName => $property)
                                <li class="whitespace-nowrap truncate">{{ $property['Nev'] }}</li>
                            @endforeach
                        </ul>
                    </div> <!-- .features -->

                    <div class="cd-products-wrapper">
                        <ul class="cd-products-columns">

                            @foreach($products as $product)
                                <li class="product relative">

                                    <button class="close absolute top-[50px] right-[30px] z-[1]"
                                            data-url="{{ route('comparison.delete', ['Termek_ID' => $product->Termek_ID, 'locale' => app('Lang')->getLocale()]) }}">
                                        <i class="fas fa-times-circle text-red-400 hover:text-red-500"></i>
                                    </button>


                                    <div class="top-info flex flex-col">
                                        <div class="check mb-4"></div>
                                        <a class="flex justify-center my-2"
                                           href="{{ LUrl::routeProduct($product) }}">
                                            @include('pages.products.includes.main-image', [
                                                'product' => $product,
                                                'size' => 'product-small',
                                                'mode' => 'img',
                                                'style' => 'height: 60px'
                                            ])
                                        </a>
                                        <h3 class="mt-[auto] mb-0">
                                            <a href="{{ LUrl::routeProduct($product) }}" class="text-gray-500">
                                                <div class="font-semibold grow">{{ $product->Kod }}</div>

                                                @if(Fct::isRielActive())
                                                    @if($product->Kifuto && $product->getStock() == 0)
                                                        <div class="wrapper">
                                                            <div class="notloggedin">
                                                                @lang('pages/products.not_available')
                                                            </div>
                                                        </div>
                                                    @else
                                                        @php $prices = $product->getPrices(); @endphp
                                                        @if($prices->UgyfelAr)

                                                            <div class="text-2xs text-gray-500 leading-none">
                                                                @lang($prices->ListaAr == $prices->UgyfelAr ? 'prices.fix_price' : 'prices.discounted_price')
                                                            </div>

                                                            <div class="text-lg text-riel-light font-bold">
                                                                {{ Fct::price($prices->UgyfelAr) }} <span
                                                                    class="text-xs text-gray-500">+ @lang('prices.vat')</span>
                                                            </div>

                                                        @else
                                                            <div class="text-gray-500 font-semibold">
                                                                @lang('prices.no_price')
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif

                                            </a>
                                        </h3>


                                    </div> <!-- .top-info -->

                                    <ul class="cd-features-list">

                                        @foreach($allProperties as $innerName => $property)
                                            @if(isset($allProperties[$innerName]['Ertekek'][$product->Termek_ID]))
                                                <li class="whitespace-nowrap truncate @if($property['repeating']) text-gray-400 @endif">{{ $allProperties[$innerName]['Ertekek'][$product->Termek_ID] }}</li>
                                            @else
                                                <li class="whitespace-nowrap truncate @if($property['repeating']) text-gray-400 @endif">-</li>
                                            @endif
                                        @endforeach

                                    </ul>
                                </li>
                            @endforeach

                        </ul> <!-- .cd-products-columns -->
                    </div> <!-- .cd-products-wrapper -->

                    <ul class="cd-table-navigation">
                        <li><a href="#0" class="prev inactive">Prev</a></li>
                        <li><a href="#0" class="next">Next</a></li>
                    </ul>
                </div> <!-- .cd-products-table -->
            </section>
        @else
            <h3 class="text-xl text-center mt-20">{{trans('pages/comparison.no_selected_product')}}</h3>
        @endif
    </div>
@endsection


@push('scripts')
    <script src="{{ mix('js/comparison.js') }}"></script>
@endpush
