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

    @foreach($categories as $category)
        <div class="md:flex mb-4 mt-12 text-center md:text-left">
            <a href="{{ LUrl::route('videos.categories.show', $category->slug) }}"
               class="text-inherit text-2xl text-center font-thin grow">
                <h2 class="">{{ $category->name }}</h2>
            </a>

            @if($category->videos->count() > 4)
                <a href="{{ LUrl::route('videos.categories.show', $category->slug) }}"
                   class="text-inherit uppercase md:text-right md:flex md:items-end">@lang('global.all')
                    ({{ $category->videos->count() }})</a>
            @endif
        </div>

        <div class="clear-both">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @include('pages.videos.includes.items', ['videos' => $category->videos->take(4)])
            </div>
        </div>
    @endforeach

@endsection
