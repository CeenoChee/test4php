@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/auth.update_password')
@endsection

@section('content_title')
    @lang('pages/auth.update_password')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('update-password') }}
@endsection

@section('top')
    @include('includes.profile-check-alert')
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    <x-card class="mb-8">

        <form method="POST" action="{{ route('password.update', ['locale' => app('Lang')->getLocale()]) }}">

            @csrf

            <label for="email">@lang('form.email')</label>
            <input id="password" type="text"
                   class="form-control" value="{{ $user->email }}" disabled="disabled">


            <label for="current_password" class="required">@lang('form.current_password')</label>
            <input id="password" type="password" required placeholder="@lang('form.placeholder.current_password')"
                   class="{{ $errors->has('current_password') ? ' invalid' : '' }}" name="current_password">
            <x-input-error :field="'current_password'" />

            <label for="password" class="required">@lang('form.new_password')</label>
            <input id="password" type="password" required placeholder="@lang('form.placeholder.new_password')"
                   class="{{ $errors->has('password') ? ' invalid' : '' }}" name="password">
            <x-input-error :field="'password'" />

            <label for="password_confirmation" class="required">@lang('form.password_confirmation')</label>
            <input id="password_confirmation" type="password" required placeholder="@lang('form.placeholder.confirm_password')"
                   class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                   name="password_confirmation">
            <x-input-error :field="'password_confirmation'" />

            <button type="submit" class="btn">@lang('pages/auth.update_password')</button>

        </form>
    </x-card>

@endsection

