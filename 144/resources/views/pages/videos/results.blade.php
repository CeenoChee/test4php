@extends('layouts.app')

@section('title')
    @lang('pages/videos.videos')
@endsection

@section('content_title')
    @lang('pages/videos.videos')
@endsection

@section('meta_description')
    @lang('pages/videos.videos_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('videos.index') }}
@endsection

@section('content')

    @include('pages.videos.includes.search-form')

    @if($videos->count() > 0)
        <h2 class="text-center text-lg mb-4">
            @lang('global.results', ['keyword' => $keyword]):
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        @include('pages.videos.includes.items')
        </div>

    @else
        <h2 class="text-center text-xl">
            @lang('global.no_results', ['keyword' => $keyword])
        </h2>
    @endif
@endsection
