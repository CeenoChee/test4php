@extends('layouts.app')

@section('title')
    419 - Az oldal lejárt
@endsection

@section('content')

    <div class="bg-gradient-to-r from-orange-200 to-yellow-400 shadow-2xl py-12 rounded">
        <div class="flex flex-col items-center">
            <h1 class="font-bold text-orange-500 text-9xl mb-4">419</h1>

            <h6 class="mb-2 text-2xl font-bold text-center text-gray-900 md:text-3xl">
                <span class="text-white">@lang('errors.oops')</span> <span
                    class="text-gray-600 ">Az oldal érvényessége már lejárt!</span>
            </h6>
            

            <a href="/" class="px-6 py-2 text-sm font-semibold btn">@lang('pages/home.home')</a>
        </div>
    </div>

@endsection
