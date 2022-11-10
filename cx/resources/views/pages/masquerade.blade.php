@extends('layouts.app')

@section('title')
    Masquerade
@endsection

@section('content_title')
    Masquerade
@endsection

@section('meta_description')
    Masquerade
@endsection

@section('content')

    <form method="POST" action="{{ route('masquerade.set') }}" class="mx-auto w-1/2">
        <fieldset class="noframe">
            <div class="formgrid">

                @csrf
                <label for="email">@lang('form.email')</label>
                <input id="email" type="email" placeholder="@lang('form.email')" required
                       class="{{ $errors->has('email') ? ' invalid' : '' }}" name="email"
                       value="{{ old('email') }}" autofocus>
               <x-input-error :field="'email'" />


                <button type="submit" class="btn mt-4">@lang('pages/auth.login')</button>
            </div>
        </fieldset>
    </form>

@endsection
