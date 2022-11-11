@extends('layouts.app')

@section('title')
    @lang('pages/auth.login')
@endsection

@section('content_title')
    @lang('pages/auth.login')
@endsection

@section('meta_description')
    @lang('pages/auth.login_meta_description')
@endsection

@section('content')
    <x-card class="w-full md:w-1/2 mx-auto">

        <div class="text-center text-2xl text-riel-light mb-2">
            <i class="fal fa-user-circle"></i>
        </div>

        <form method="POST" action="{{ route('login', ['locale' => app('Lang')->getLocale()]) }}">
            @csrf
            <label for="email">@lang('form.email')</label>
            <input id="email" type="email" placeholder="@lang('form.placeholder.email')" required
                   class="{{ $errors->has('email') ? ' invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus>
            <x-input-error :field="'email'"/>


            <label for="password">@lang('form.password')</label>
            <input id="password" type="password" placeholder="@lang('pages/auth.placeholder.password')" required
                   class="{{ $errors->has('password') ? ' invalid' : '' }}" name="password" value="{{ old('password') }}">
            <x-input-error :field="'password'"/>

            <input type="hidden" name="previous_url" value="{{ old('previous_url', $previous_url) }}">

            <div class="grid grid-cols-1 grid-rows-2 md:grid-cols-2 md:grid-rows-1 gap-2">
                <div>
                    <button type="submit" class="btn w-full">@lang('pages/auth.login')</button>
                </div>

                <div>
                    <a class="btn-outline w-full" href="{{ LUrl::route('register') }}">
                        @lang('pages/auth.register')
                    </a>
                </div>

            </div>

            <div class="mt-2 text-center md:text-left">
                <a class="text-riel-light text-right" href="{{ LUrl::route('password.request') }}">
                    @lang('pages/auth.forgot_password')
                </a>
            </div>

        </form>
    </x-card>

@endsection
