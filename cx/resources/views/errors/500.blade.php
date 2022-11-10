@extends('layouts.app')

@section('title')
    500
@endsection

@section('content')

    <div class="bg-gradient-to-r from-orange-200 to-red-600 shadow-2xl py-12 rounded">
        <div class="flex flex-col items-center">
            <h1 class="font-bold text-red-800 text-9xl mb-4">500</h1>

            <h6 class="mb-2 text-2xl font-bold text-center text-gray-900 md:text-3xl">
                <span class="text-red-600">@lang('errors.oops')</span> <span
                    class="text-gray-600 ">@lang('errors.500.server_error')</span>
            </h6>

            <p class="mb-8 text-center text-gray-900 md:text-lg">
                @lang('errors.500.text')
            </p>

            <a href="{{LUrl::route('contact')}}" class="px-6 py-2 text-sm font-semibold btn">@lang('pages/contact.contact')</a>
        </div>
    </div>

@endsection
