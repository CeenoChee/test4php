@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/videos.videos') - {{ $category->name }}
@endsection

@section('content_title')
    @lang('pages/videos.videos') - {{ $category->name }}
@endsection

@section('meta_description')
    @lang('pages/videos.videos_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('videos.categories.show', $category) }}
@endsection

@section('sidebar')

    <div class="text-lg my-4 text-center uppercase font-thin text-gray-500">
        @lang('global.categories')
    </div>

    <x-card>
        @foreach($categories as $cat)
            @if($cat->videos->count() > 0)
                <h3 class="font-bold text-base mb-1 text-gray-600">
                    <a href="{{ LUrl::route('videos.categories.show', $cat->slug) }}">
                        {{ $cat->name }}
                    </a>
                </h3>
                <ul class="">
                    @foreach($cat->videos->take(3) as $video)
                        <li class="mb-2 text-xs">
                            <i class="fal fa-circle-play"></i>
                            <a href="{{$video->url}}" class="">
                                {{ $video->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-2 mb-6">
                    <a href="{{ LUrl::route('videos.categories.show', $cat->slug) }}"
                       class="text-xs text-2xs text-riel-light hover:text-riel-dark">
                        @lang('global.all')
                    </a>
                </div>

            @endif
        @endforeach
    </x-card>
@endsection


@section('right-content')

    <div class="mx-auto mb-4">
        <form class="relative" method="get" action="{{ LUrl::route('videos.search') }}">
            <div class="flex">
                <input type="text" class="!pr-12" name="keyword" value="@if(isset($keyword)){{$keyword}}@endif"
                       placeholder="@lang('global.placeholder.search')" required/>
            </div>

            <button class="absolute top-0 right-0 w-12 h-10 text-lg">
                <i class="fal fa-search"></i>
            </button>
        </form>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @include('pages.videos.includes.items', ['videos' => $category->videos])
    </div>

@endsection
