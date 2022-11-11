@extends('layouts.app')

@section('title')
    403
@endsection

@section('content')

    <div class="bg-gradient-to-r from-red-200 to-red-400 shadow-2xl py-12 rounded">
        <div class="flex flex-col items-center">
            <h1 class="font-bold text-red-500 text-9xl mb-4">403</h1>

            <h6 class="mb-2 text-2xl font-bold text-center text-gray-900 md:text-3xl">
                <span class="text-white">@lang('errors.oops')</span> <span
                    class="text-gray-600 ">Az oldal az Ön számára nem elérhető!</span>
            </h6>

            <p class="mb-8 text-center text-gray-900 md:text-lg">
                Az oldal megtekintésére nem jogosult
            </p>

            <a href="#" class="px-6 py-2 text-sm font-semibold btn">@lang('pages/home.home')</a>
        </div>
    </div>

@endsection
