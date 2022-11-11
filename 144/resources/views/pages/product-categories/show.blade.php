@extends('layouts.app')

@section('title')
    @lang('pages/products.categories')
@endsection


@section('meta_description')
    {{ $productCategory ? $productCategory->trans->RovidLeiras : '' }}
@endsection


@section('content')
    <div class="xl:flex ">

        <input type="hidden" id="keywords" value="{{ request('kulcsszo') }}"/>

        <div class="basis-1/4">
            <div class="xl:w-72 w-full px-4 py-8 rounded-md shadow-2xl bg-white mb-4 mr-4" >
                {{--        Ez majd kell!!!--}}
                {{--        <button class="filter-toggle" data-target="cat-nav">@lang('pages/products.categories')</button>--}}
                {{--        <button class="filter-toggle" data-target="filter-navigator">@lang('pages/products.filter')</button>--}}

                <div class="uppercase text-xs font-bold text-riel-light mb-2">
                    @lang('pages/products.categories')
                </div>
                <div class="p-4 rounded-md mb-4" id="cat-nav" data-category-url="{{ LUrl::routeCategory($productCategory) }}">

                    <div class="category">
                        <div id="cat-navigator-content">
                            {!! $navigator !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:w-72 w-full px-4 py-8 rounded-md shadow-2xl bg-white" >
                <div class="uppercase text-xs font-bold text-riel-light mb-2">@lang('pages/products.filter')</div>
                <div class="p-4 rounded-md" id="filter-navigator">

                    <div class="filter">
                        <div id="dynamic-filters">
                            {!! $filters !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div class="basis-3/4">
            <div class="qSearch mb-4" id="qsearch" data-placeholder="@lang('global.qsearch')" data-keyword="@lang('global.keyword')">
            </div>

            @include('includes.redirect-login-modal')
            <div id="product-category-show">

                <div id="product-category-list-loading" class="loading-icon">
                    <div class="loading-icon-center">
                        <div class="loading-icon-wrapper">
                            <div class="spinner"></div>
                            <img src="{{ asset('assets/images/riellogo.png') }}"/>
                        </div>
                    </div>
                </div>

                <div id="product-category-list">
                    {!! $productList !!}
                </div>
            </div>
        </div>
    </div>


@endsection
@section('bottom')
    {!! app('Comparison')->renderBox() !!}
@endsection
