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

    @include('pages.knowledges.includes.search-form')

    <div class="text-lg mt-8 mb-10 text-center uppercase font-thin">
        @lang('global.categories')
    </div>

    <div class="grid md:grid-cols-3 lg:grid-cols-4">
        @foreach($categories as $category)

            @if($category->isRoot())
                @include('pages.knowledges.includes.category-item')
            @endif

        @endforeach
    </div>
@endsection
