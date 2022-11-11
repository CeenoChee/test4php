@extends('layouts.app')

@section('title')
    @lang('pages/divisions.title')
@endsection

@section('content_title')
    @lang('pages/divisions.title')
@endsection

@section('meta_description')
    @lang('pages/divisions.meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('divisions') }}
@endsection

@section('content')

    <x-prologue>
        @lang('pages/divisions.intro')
    </x-prologue>

    <div class="text-center my-8">
        <a href="https://cdn.flipsnack.com/widget/v2/widget.html?hash=ftm84k9cb&t=1590151437" class="btn w-64 mx-auto">
            @lang('pages/divisions.company_presentation_catalog')
        </a>
    </div>

    <div class="grid grid-cols-1 grid-rows-3 lg:grid-cols-3 lg:grid-rows-1 gap-4 lg:gap-8 xl:gap-16 text-center mt-20">
        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md">
            <div>
                <img src="{{ asset('assets/images/divisions/icon_security.png') }}" class="w-16 m-auto"/>
            </div>
            <div class="font-light text-lg mt-2 mb-4">
                @lang('pages/divisions.security_systems')
            </div>
            <div class="font-light mb-2">
                @lang('pages/divisions.what_we_do')
            </div>
            <div class="mb-8 md:mb-12 min-h-[168px]">
                @lang('pages/divisions.box_1')
            </div>

            <a href="https://www.riel.hu" class="btn">@lang('form.next')</a>

        </div>

        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md">
            <div>
                <img src="{{ asset('assets/images/divisions/icon_inspections.png') }}" class="w-16 m-auto"/>
            </div>
            <div class="font-light text-lg mt-2 mb-4">
                @lang('pages/divisions.security_inspections')
            </div>
            <div class="font-light mb-2">
                @lang('pages/divisions.what_we_do')
            </div>
            <div class="mb-8 md:mb-12 min-h-[168px]">
                @lang('pages/divisions.box_2')
            </div>

            <a href="https://www.riel.hu" class="btn">@lang('form.next')</a>

        </div>

        <div class="shadow-2xl border border-solid border-neutral-200 p-8 rounded-md">
            <div>
                <img src="{{ asset('assets/images/divisions/icon_industrial.png') }}" class="w-16 m-auto"/>
            </div>
            <div class="font-light text-lg mt-2 mb-4">
                @lang('pages/divisions.industrial_solutions')
            </div>
            <div class="font-light mb-2">
                @lang('pages/divisions.what_we_do')
            </div>
            <div class="mb-8 md:mb-12 min-h-[168px]">
                @lang('pages/divisions.box_3')
            </div>

            <a href="https://www.beu.riel.hu/" class="btn" target="_blank">@lang('form.next')</a>

        </div>
    </div>

@endsection
