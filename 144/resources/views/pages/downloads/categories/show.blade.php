@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/downloads.downloads')
@endsection

@section('content_title')
    @lang('pages/downloads.downloads') - {{ $category->translation->name }}
@endsection

@section('meta_description')
    @lang('pages/downloads.downloads_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('download.categories.show', $category) }}
@endsection

@section('sidebar')

    <div class="text-lg mb-6 text-center uppercase font-thin text-gray-500">
        @lang('global.categories')
    </div>


    <ul>
        @if($category->parent)
            @foreach($siblingCategories as $siblingCategory)
                <li class="mb-2">
                    <div class="px-2 items-center flex">
                        <i class="fal text-sm fa-chevron-right mr-2"></i>
                        <a href="{{ LUrl::route('download.categories.show', ['downloadCategorySlug' => $siblingCategory->translation->slug]) }}"
                           class="text-inherit @if($siblingCategory->id == $category->id) font-bold @endif">{{$siblingCategory->translation->name}}</a>
                    </div>
                </li>
            @endforeach
        @else
            @foreach($rootCategories as $rootCategory)
                @if($rootCategory->isRoot())
                    <li class="mb-2">
                        <div class="rounded-full px-2 items-center flex">
                            <i class="fal text-sm fa-chevron-right mr-2"></i>
                            <a href="{{ LUrl::route('download.categories.show', ['downloadCategorySlug' => $rootCategory->translation->slug]) }}"
                               class="text-inherit @if($rootCategory->id == $category->id) font-bold @endif">{{$rootCategory->translation->name}}</a>
                        </div>


                        @if($category->id == $rootCategory->id && $rootCategory->children->count() > 0)
                            <ul>
                                @foreach($rootCategory->children as $subCategory)
                                    @if($subCategory->downloads->count() > 0 )
                                        <li class="ml-8">
                                            <i class="fal text-xs fa-circle-small mr-2 text-riel-light"></i>
                                            <a href="#{{$subCategory->translation->slug}}" class="text-inherit download-sub"
                                               data-slug="{{$subCategory->translation->slug}}">{{$subCategory->translation->name}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif

                    </li>
                @endif
            @endforeach
        @endif

    </ul>
@endsection


@section('right-content')

    <form class="mb-4" method="get" action="{{ LUrl::route('download.results') }}">
        <div class="flex">
            <input type="text" class="!pr-12" name="keyword" value="@if(isset($keyword)){{$keyword}}@endif"
                   placeholder="@lang('global.placeholder.search')" required/>
        </div>

        <button class="absolute top-0 right-0 w-12 h-10 text-lg">
            <i class="fal fa-search"></i>
        </button>
    </form>

    <div class="text-gray-500">
        {{$category->translation->brief}}
    </div>


    @if($childCategories->count() > 0)

        @foreach($childCategories as $subCategory)

            <div class="font-thin text-riel-light rounded-md text-center text-3lg my-8"
                 id="{{ $subCategory->translation->slug }}">
                {{ $subCategory->translation->name }}
            </div>

            @include('pages.downloads.includes.items', ['downloads' => $subCategory->downloads])

        @endforeach

    @else
        @include('pages.downloads.includes.items', ['downloads' => $category->downloads])
    @endif

@endsection



@push('scripts')
    <script>
        if (location.hash.length > 0) {
            scrollToDownloadCategory(location.hash);
        }

        function scrollToDownloadCategory(id) {

            $('html, body').animate({
                scrollTop: $(id).offset().top - 60
            }, 500);
        }

        $('.download-sub').click(function (e) {
            e.preventDefault();

            scrollToDownloadCategory('#' + $(this).data('slug'));

            location.hash = $(this).data('slug');
        });
    </script>
@endpush
