@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/knowledge.knowledge')
@endsection

@section('content_title')
    @lang('pages/knowledge.knowledge') - {{$category->translation->name}}
@endsection

@section('meta_description')
    @lang('pages/knowledge.knowledge_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('knowledge.category', $category) }}
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
                        <a href="{{ LUrl::route('knowledge.category', ['slug' => $siblingCategory->translation->slug]) }}"
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
                            <a href="{{ LUrl::route('knowledge.category', ['slug' => $rootCategory->translation->slug]) }}"
                               class="text-inherit @if($rootCategory->id == $category->id) font-bold @endif">{{$rootCategory->translation->name}}</a>
                        </div>


                        @if($category->id == $rootCategory->id && $rootCategory->children->count() > 0)
                            <ul>
                                @foreach($rootCategory->children as $subCategory)
                                    @if($subCategory->knowledges->count() > 0 )
                                        <li class="ml-8">
                                            <i class="fal text-xs fa-circle-small mr-2 text-riel-light"></i>
                                            <a href="#{{$subCategory->translation->slug}}" class="text-inherit knowledge-sub"
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

        @include('pages.knowledges.includes.sidebar.contacts')
    </ul>
@endsection

@section('right-content')


    <form class="relative" method="get" action="{{ LUrl::route('knowledge.results') }}">
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

            @foreach($subCategory->knowledges as $knowledge)
                @include('pages.knowledges.includes.knowledge-item')
            @endforeach

            @if(isset($videos[$subCategory->id]))
                <div class="sm:w-[640px] md:w-[768px] 2xl:w-[1000px]">
                    <ul class="light-slider !min-h-[230px] py-2">
                        @foreach($videos[$subCategory->id] as $video)
                            <li>
                                <div class="bg-white shadow-md rounded-md">
                                    <a class="text-inherit" target="_blank" href="{{$video->url}}">
                                        <div>
                                            <img src="{{ $video->image }}" class="rounded-t-md">
                                        </div>

                                        <div class="px-4 pb-4">
                                            <h4 class="font-bold text-xs my-3 h-8 overflow-y-hidden">{{ $video->title }}</h4>

                                            <div class="text-xs">
                                                <i class="fal fa-eye"></i> {{ $video->views }} @lang('pages/videos.views')
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        @endforeach

    @else
        @foreach($category->knowledges as $knowledge)
            @include('pages.knowledges.includes.knowledge-item')
        @endforeach
    @endif
@endsection

@push('scripts')
    <script>
        if (location.hash.length > 0) {
            scrollToKnowledgeCategory(location.hash);
        }

        function scrollToKnowledgeCategory(id) {

            $('html, body').animate({
                scrollTop: $(id).offset().top - 60
            }, 500);
        }

        $('.knowledge-sub').click(function (e) {
            e.preventDefault();

            scrollToKnowledgeCategory('#' + $(this).data('slug'));

            location.hash = $(this).data('slug');
        });


        $(document).ready(function () {
            $(".light-slider").lightSlider(
                {
                    item: 4,
                    pager: false,
                    slideMargin: 15,

                    responsive: [
                        {
                            breakpoint: 1537,
                            settings: {
                                item: 3,
                                slideMove: 1,
                                slideMargin: 6,
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                item: 2,
                                slideMove: 1
                            }
                        }
                    ]
                }
            );
        });


    </script>
@endpush

<style>
    .lSAction > a {
        filter: drop-shadow(0px 0px 5px black);
    }
</style>
