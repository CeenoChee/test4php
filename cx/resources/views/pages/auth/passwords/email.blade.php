@extends('layouts.app')

@section('title')
    @lang('pages/auth.forgot_password')
@endsection

@section('content_title')
    @lang('pages/auth.forgot_password')
@endsection

@section('content')
    <x-card class="w-full md:w-1/2 mx-auto">
        <form method="POST" action="{{ route('password.email', ['locale' => app('Lang')->getLocale()]) }}">

            @csrf
            <label for="email" class="required">@lang('form.email')</label>
            <input id="email" type="email" placeholder="@lang('form.placeholder.email')"
                   class="{{ $errors->has('email') ? ' invalid' : '' }}" name="email"
                   value="{{ old('email') }}" required autofocus>
            <x-input-error :field="'email'"/>

            <button type="submit" class="btn">@lang('pages/auth.password_reset')</button>

        </form>
    </x-card>

@endsection
