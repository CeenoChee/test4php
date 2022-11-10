@extends('layouts.app')

@section('title')
    404
@endsection

@section('content')

    <div class="bg-gradient-to-r from-sky-200 to-sky-400 shadow-2xl py-12 rounded">
        <div class="flex flex-col items-center">
            <h1 class="font-bold text-riel-light text-9xl mb-4">404</h1>

            <h6 class="mb-2 text-2xl font-bold text-center text-gray-900 md:text-3xl">
                <span class="text-white">@lang('errors.oops')</span> <span
                    class="text-gray-600 ">@lang('errors.404.page_not_found')</span>
            </h6>

            <p class="mb-8 text-center text-gray-900 md:text-lg">
                @lang('errors.404.text')
            </p>

            <a href="/" class="px-6 py-2 text-sm font-semibold btn">@lang('pages/home.home')</a>
        </div>
    </div>

@endsection
