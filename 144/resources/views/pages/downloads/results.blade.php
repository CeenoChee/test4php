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

    @if($downloads->count() > 0)

        <h2 class="text-center text-lg mb-4">
            @lang('global.results', ['keyword' => $keyword]):
        </h2>

    @include('pages.downloads.includes.result-items')

    @else
        <h2 class="text-center text-xl">
            @lang('global.no_results', ['keyword' => $keyword])
        </h2>
    @endif
@endsection
