@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/export.price_list')
@endsection

@section('content_title')
    @lang('pages/export.price_list')
@endsection

@section('meta_description')
    @lang('pages/export.price_list_download_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('export') }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    <div class="grid grid-cols-1 grid-rows-3 lg:grid-cols-3 lg:grid-rows-1 lg:gap-8 xl:gap-4 text-center">

        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md">
            <div>
                <img class="w-16 mx-auto" src="{{ asset('assets/images/support/downloads/excel.png') }}">
            </div>

            <h3 class="font-light text-lg mt-2 mb-4">
                @lang('pages/export.xlsx.title')
            </h3>

            <div class="xl:min-h-[150px] mb-5">
                @lang('pages/export.xlsx.text')
            </div>

            <a class="btn font-bold" target="_blank" href="{{ LUrl::route('export.download', ['type' => 'xlsx']) }}">
                <i class="fa fa-download"></i> @lang('pages/downloads.download')
            </a>
        </div>


        <div class="shadow-2xl bg-white border border-solid border-neutral-200 p-8 rounded-md">
            <div>
                <img class="w-16 mx-auto" src="{{ asset('assets/images/support/downloads/oldexcel.png') }}">
            </div>

            <h3 class="font-light text-lg mt-2 mb-4">
                @lang('pages/export.xls.title')
            </h3>

            <div class="xl:min-h-[150px] mb-5">
                @lang('pages/export.xls.text')
            </div>

            <a class="btn font-bold" target="_blank"
               href="{{ LUrl::route('export.download', ['type' => 'xls']) }}">
                <i class="fa fa-download"></i> @lang('pages/downloads.download')
            </a>
        </div>


        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md">
            <div>
                <img class="w-16 mx-auto" src="{{ asset('assets/images/support/downloads/csv.png') }}">
            </div>

            <h3 class="font-light text-lg mt-2 mb-4">
                @lang('pages/export.csv.title')
            </h3>

            <div class="xl:min-h-[150px] mb-5">
                @lang('pages/export.csv.text')
            </div>

            <a class="btn font-bold" target="_blank"
               href="{{ LUrl::route('export.download', ['type' => 'csv']) }}">
                <i class="fa fa-download"></i> @lang('pages/downloads.download')
            </a>
        </div>
    </div>





@endsection


