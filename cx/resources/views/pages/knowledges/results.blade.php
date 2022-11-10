@extends('layouts.app')

@section('title')
    @lang('pages/knowledge.knowledge')
@endsection

@section('content_title')
    @lang('pages/knowledge.knowledge')
@endsection

@section('meta_description')
    @lang('pages/knowledge.knowledge_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('knowledge') }}
@endsection


@section('content')

    @include('pages/knowledges.includes.search-form')

    @if($knowledges->count() > 0 || $categories->count() > 0)

        <h2 class="text-center text-lg mb-4">
            @lang('global.results', ['keyword' => $keyword]):
        </h2>

        @if($categories->count() > 0)
            <div class="text-lg mt-8 mb-6 uppercase font-thin">
                @lang('global.categories')
            </div>

            <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-8 gap-8">
                @foreach($categories as $category)
                    <div>
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
        @endif

        @if($knowledges->count() > 0)

            <div class="text-lg mt-10 mb-6 uppercase font-thin">
                @lang('pages/knowledge.articles')
            </div>

            @foreach($knowledges as $knowledge)
                @include('pages.knowledges.includes.knowledge-item', ['category' => $knowledge->categories->first()])
            @endforeach
        @endif

    @else
        <h2 class="text-center text-xl mt-10">
            @lang('global.no_results', ['keyword' => $keyword])
        </h2>
    @endif
@endsection
