@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/warranty.css') }}" rel="stylesheet">
@endsection

@section('title')
    @lang('pages/warranties.warranty')
@endsection

@section('content_title')
    @lang('pages/warranties.warranty')
@endsection

@section('meta_description')
    @lang('pages/warranties.warranty_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('warranty') }}
@endsection

@section('content')
    <x-prologue>
        @lang('pages/warranties.main_text')
    </x-prologue>


    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
        <a href="#hikvision" class="py-4 px-8 bg-white rounded-md shadow-md warranty-item" data-slug="hikvision">
            <img class="w-48 mx-auto" src="{{ asset('assets/images/main/logos/Hikvision.png') }}">
        </a>

        <a href="#satel" class="py-4 px-8 bg-white rounded-md shadow-md warranty-item" data-slug="satel">
            <img class="w-48 mx-auto" src="{{ asset('assets/images/main/logos/Satel.png') }}">
        </a>

        <a href="#vanderbilt" class="py-4 px-8 bg-white rounded-md shadow-md warranty-item" data-slug="vanderbilt">
            <img class="w-48 mx-auto" src="{{ asset('assets/images/main/logos/Vanderbilt.png') }}">
        </a>

        <a href="#dallmeier" class="py-4 px-8 bg-white rounded-md shadow-md warranty-item" data-slug="dallmeier">
            <img class="w-48 mx-auto" src="{{ asset('assets/images/main/logos/Dallmeier.png') }}">
        </a>

        <a href="#siemens" class="py-4 px-8 bg-white rounded-md shadow-md warranty-item" data-slug="siemens">
            <img class="w-48 mx-auto" src="{{ asset('assets/images/main/logos/Siemens.png') }}">
        </a>

        <a href="#wd" class="py-4 px-8 bg-white rounded-md shadow-md warranty-item" data-slug="wd">
            <img class="w-40 mx-auto" src="{{ asset('assets/images/main/logos/WD.png') }}">
        </a>

        <a href="#comunello" class="py-4 px-8 bg-white rounded-md shadow-md warranty-item" data-slug="comunello">
            <img class="w-48 mx-auto" src="{{ asset('assets/images/main/logos/Comunello.png') }}">
        </a>
    </div>


    <x-card class="warranty-text-box hidden mt-8 mb-16 py-8" id="warranty">

        <div class="hidden warranty-text" id="hikvision">
            <h2 class="text-2lg text-riel-dark mb-6">Hikvision</h2>
            <h3 class="font-bold">@lang('pages/warranties.general_warranty')</h3>
            <div class="mb-4">
                @lang('pages/warranties.hikvision_general_text')
            </div>
            <h3 class="font-bold">@lang('pages/warranties.replacement_warranty')</h3>
            <div class="mb-4">
                @lang('pages/warranties.hikvision_replacement_text')
            </div>
            <div class="scale-[0.85] relative right-[40px] xs:right-0 xs:scale-100">
                @lang('pages/warranties.hikvision_table')
            </div>
        </div>

        <div class="hidden warranty-text" id="satel">
            <h2 class="text-2lg text-riel-dark mb-6">Satel</h2>
            <h3 class="font-bold">@lang('pages/warranties.general_warranty')</h3>
            <div class="text">
                @lang('pages/warranties.satel_general_text')
            </div>
            <div class="scale-[0.85] relative right-[40px] xs:right-0 xs:scale-100">
                @lang('pages/warranties.satel_table')
            </div>
        </div>

        <div class="hidden warranty-text" id="vanderbilt">
            <h2 class="text-2lg text-riel-dark mb-6">Vanderbilt</h2>
            <h3 class="font-bold">@lang('pages/warranties.general_warranty')</h3>
            <div class="text">
                @lang('pages/warranties.vanderbilt_general_text')
            </div>
        </div>

        <div class="hidden warranty-text" id="dallmeier">
            <h2 class="text-2lg text-riel-dark mb-6">Dallmeier</h2>
            <h3 class="font-bold">@lang('pages/warranties.general_warranty')</h3>
            <div class="text">
                @lang('pages/warranties.dallmeier_general_text')
            </div>
        </div>

        <div class="hidden warranty-text" id="siemens">
            <h2 class="text-2lg text-riel-dark mb-6">Siemens</h2>
            <h3 class="font-bold">@lang('pages/warranties.general_warranty')</h3>
            <div class="text">
                @lang('pages/warranties.siemens_general_text')
            </div>
        </div>

        <div class="hidden warranty-text" id="wd">
            <h2 class="text-2lg text-riel-dark mb-6">Western Digital</h2>
            <h3 class="font-bold">@lang('pages/warranties.general_warranty')</h3>
            <div class="text">
                @lang('pages/warranties.wd_general_text')
            </div>
        </div>

        <div class="hidden warranty-text" id="comunello">
            <h2 class="text-2lg text-riel-dark mb-6">Comunello</h2>
            <h3 class="font-bold">@lang('pages/warranties.general_warranty')</h3>
            <div class="text">
                @lang('pages/warranties.comunello_general_text')
            </div>
        </div>

    </x-card>

    <h2 class="font-thin text-2xl text-center my-8 text-riel-dark">
        @lang('pages/warranties.procedure_title')
    </h2>
    <x-prologue>
        @lang('pages/warranties.procedure_text')
    </x-prologue>



    <h2 class="font-thin text-2xl text-center my-8 text-riel-dark">
        @lang('pages/warranties.not_under_warranty')
    </h2>
    <x-prologue>
        @lang('pages/warranties.not_under_warranty_text')
        <ul class="text-left mt-8 ml-16 list-[circle]">
            @lang('pages/warranties.not_under_warranty_list')
        </ul>
    </x-prologue>


@endsection

@push('scripts')
    <script>

        if (location.hash.length > 0) {
            scrollToWarranty(location.hash);
        }

        function scrollToWarranty(id) {

            $('.warranty-text-box').removeClass('hidden');
            $('.warranty-text').addClass('hidden');
            $(id).toggleClass('hidden');

            $('html, body').animate({
                scrollTop: $(id).offset().top - 350
            }, 500);
        }

        $('.warranty-item').click(function (e) {
            e.preventDefault();

            $('.warranty-item').removeClass('bg-sky-200').addClass('bg-white');
            $(this).addClass('bg-sky-200');

            scrollToWarranty('#' + $(this).data('slug'));

            location.hash = $(this).data('slug');
        });

    </script>
@endpush
