@extends('layouts.app')

@section('title')
    @lang('pages/tickets.tickets')
@endsection

@section('content_title')
    @lang('pages/tickets.tickets')
@endsection

@section('meta_description')
    @lang('pages/tickets.tickets_meta_description')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('ticket') }}
@endsection

@section('content')

    <x-prologue>
        @lang('pages/tickets.main_text')
    </x-prologue>

    <x-card>
        <form method="POST" action="{{ route('ticket.post', ['locale' => app('Lang')->getLocale()]) }}">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="name" class="required">@lang('form.name')</label>
                    <input id="name" type="text" placeholder="@lang('form.placeholder.name')"
                           class="{{ $errors->has('name') ? ' invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                    <x-input-error :field="'name'" />
                </div>


                <div>
                    <label for="email" class="required">@lang('form.email')</label>
                    <input id="email" type="email" placeholder="@lang('form.placeholder.email')"
                           class="{{ $errors->has('email') ? ' invalid' : '' }}" name="email"
                           value="{{ old('email') }}" required>
                    <x-input-error :field="'email'" />
                </div>


                <div>
                    <label for="phone" class="required">@lang('form.phone_number')</label>
                    <input id="phone" type="text" placeholder="@lang('form.placeholder.phone')"
                           class="{{ $errors->has('phone') ? ' invalid' : '' }}" name="phone"
                           value="{{ old('phone') }}" required>
                    <x-input-error :field="'phone'" />
                </div>

            </div>



            <label for="message" class="required">@lang('pages/tickets.error_description')</label>
            <textarea id="message" placeholder="@lang('pages/tickets.placeholder.error_description')"
                      class="{{ $errors->has('message') ? ' invalid' : '' }}"
                      name="message" rows="4" cols="50" required></textarea>
            <x-input-error :field="'message'" />


            <button type="submit" class="btn">@lang('form.submit')</button>


        </form>
    </x-card>



@endsection
