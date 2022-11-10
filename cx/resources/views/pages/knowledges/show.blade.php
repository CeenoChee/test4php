@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/knowledge.knowledge') - {{ $knowledge->translation->title }}
@endsection

@section('content_title')
    @lang('pages/knowledge.knowledge') - {{ $knowledge->translation->title }}
@endsection

@section('meta_description')
    {{ $knowledge->translation->title }}
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('knowledge.article', $knowledge) }}
@endsection

@section('sidebar')


    <div class="text-lg my-4 text-center uppercase font-thin text-gray-500">
        {{$category->translation->name}}
    </div>

    <ul class="text-xs">
        @foreach($category->knowledges as $article)

            @if($article->isActive())
                <li class="mb-4">
                    <div class="rounded-full px-2 items-center flex">
                        <i class="fal fa-book-open-reader mr-2 text-lg"></i>
                        <a href="{{ LUrl::route('knowledge.article', ['categorySlug' => $category->translation->slug, 'slug' => $article->translation->slug]) }}"
                           class="text-inherit @if($article->id == $knowledge->id) font-bold @endif">
                            {{$article->translation->title}}
                        </a>
                    </div>
                </li>
            @endif
        @endforeach

        @include('pages.knowledges.includes.sidebar.contacts')
    </ul>



@endsection

@section('right-content')
    <article>
        <x-card>
            {!! str_replace("/desk/file/", "https://riel.helpdocs.com/desk/file/", $knowledge->translation->body) !!}
        </x-card>
    </article>
@endsection

@push('scripts')
    <script src="{{ mix('js/knowledge.js') }}"></script>
@endpush
