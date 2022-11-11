@extends('layouts.app')

@section('title')
    @lang('pages/supports.support')
@endsection

@section('content_title')
    @lang('pages/supports.support')
@endsection

@section('meta_description')
    @lang('pages/supports.support_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('support') }}
@endsection

@section('top')
    @include('pages.support.includes.search-form')
@endsection

@section('content')

    @if($knowledgeCategories->count() || $knowledges->count() || $downloads->count() || $videos->count())
        <h2 class="text-center text-lg mb-4">
            @lang('global.results', ['keyword' => $keyword]):
        </h2>


        @if($knowledgeCategories->count())
            <h2 class="text-center mt-12 mb-8 text-xl font-thin">
                @lang('pages/supports.knowledge_categories')
            </h2>

            <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-8 gap-8">
                @foreach($knowledgeCategories->take(8) as $category)
                    <div class="">
                        <a href="{{ LUrl::route('knowledge.category', ['slug' => $category->translation->slug]) }}" class="text-inherit">
                            <div class="text-center">
                                @if($category->media->first())
                                    <img src="{{$category->media->first()->getFilesUrl() }}" class="mx-auto rounded-md h-[100px]"/>
                                @endif
                            </div>
                            <div class="font-bold mt-2 text-center">
                                {{ $category->translation->name}}
                            </div>

                            <div class="text-gray-400 text-center">
                                {{$category->translation->brief}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if($knowledgeCategories->count() > 8)
                <div class="text-riel-light my-4">
                    <a href="{{ LUrl::route('knowledge.results', ['keyword' => $keyword]) }}" class="btn-outline text-xs w-fit ml-auto mr-0 mb-6">
                        @lang('pages/supports.more_results') <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        @endif



        @if($knowledges->count())
            <h2 class="text-center mt-12 mb-8 text-xl font-thin">
                @lang('pages/knowledge.knowledge')
            </h2>

            @foreach($knowledges->take(4) as $knowledge)
                @include('pages.knowledges.includes.knowledge-item', ['category' => $knowledge->categories->first()])
            @endforeach

            @if($knowledgeCategories->count() > 4)
                <div class="text-riel-light my-4">
                    <a href="{{ LUrl::route('knowledge.results', ['keyword' => $keyword]) }}" class="btn-outline text-xs w-fit ml-auto mr-0 mb-6">
                        @lang('pages/supports.more_results') <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        @endif


        @if($downloads->count())
            <h2 class="text-center mt-12 mb-8 text-xl font-thin">
                @lang('pages/downloads.downloads')
            </h2>

            @include('pages.downloads.includes.result-items', ['downloads' => $downloads->take(4)])

            @if($downloads->count() > 4)
                <div class="text-riel-light my-4">
                    <a href="{{ LUrl::route('download.results', ['keyword' => $keyword]) }}" class="btn-outline text-xs w-fit ml-auto mr-0 mb-6">
                        @lang('pages/supports.more_results') <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
            @endif

        @endif


        @if($videos->count())
            <h2 class="text-center mt-12 mb-8 text-xl font-thin">
                @lang('pages/videos.videos')
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @include('pages.videos.includes.items', [
                    'videos' => $videos->take(4)
                ])
            </div>

            @if($videos->count() > 4)
                <div class="text-riel-light my-4">
                    <a href="{{ LUrl::route('videos.search', ['keyword' => $keyword]) }}" class="btn-outline text-xs w-fit ml-auto mr-0 mb-6">
                        @lang('pages/supports.more_results') <i class="fal fa-arrow-right"></i>
                    </a>
                </div>
            @endif

        @endif

    @else
        <h2 class="text-center text-xl">
            @lang('global.no_results', ['keyword' => $keyword])
        </h2>
    @endif

@endsection
