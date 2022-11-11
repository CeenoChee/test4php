@extends('layouts.app')

@section('title')
    503
@endsection

@section('content')

    <div class="bg-gradient-to-r from-orange-200 to-orange-500 shadow-2xl py-12 rounded">
        <div class="flex flex-col items-center">
            <h1 class="font-bold text-orange-800 text-2xl mb-4"><i class="fal fa-user-hard-hat"></i></i> @lang('errors.503.maintenance')</h1>

            <p class="mb-8 text-center text-gray-900 md:text-lg">
                @lang('errors.503.text')
            </p>

        </div>
    </div>
    <div class="text-right text-gray-600">
        {{Request::ip()}}
    </div>

@endsection
