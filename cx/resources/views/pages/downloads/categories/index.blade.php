@extends('layouts.app')

@section('title')
    @lang('pages/downloads.downloads')
@endsection

@section('content_title')
    @lang('pages/downloads.downloads')
@endsection

@section('meta_description')
    @lang('pages/downloads.downloads_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('downloads') }}
@endsection


@section('content')

    @include('pages.downloads.includes.search-form')

    <div class="text-lg mt-8 mb-10 text-center uppercase font-thin">
        @lang('global.categories')
    </div>

    <div class="grid lg:grid-cols-4 md:grid-cols-2">
        @foreach($downloadCategories as $downloadCategory)

            @if($downloadCategory->downloads->count() > 0)
                @include('pages.downloads.includes.category-item')
            @endif

        @endforeach
    </div>
@endsection
