@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/account.invite_employee')
@endsection

@section('content_title')
    @lang('pages/account.invite_employee')
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('permissions.invite_user') }}
@endsection

@section('right-content')

    <form method="POST" action="{{ route('employee.invite.user', ['locale' => app('Lang')->getLocale()]) }}">
        @csrf


        <x-card class="mb-8">

            <div class="text-riel-light mb-4 font-bold">
                @lang('pages/account.personal_data')
            </div>

            <div class="flex gap-6">
                <div class="basis-1/2">
                    <label for="lastname" class="required">@lang('form.lastname')</label>
                    <input id="lastname" type="text" required placeholder="@lang('form.placeholder.lastname')"
                           class="{{ $errors->has('lastname') ? 'invalid' : '' }}" name="lastname"
                           value="{{ old('lastname') }}">
                    <x-input-error :field="'lastname'"/>
                </div>

                <div class="basis-1/2">
                    <label for="firstname" class="required">@lang('form.firstname')</label>
                    <input id="firstname" type="text" placeholder="@lang('form.placeholder.firstname')" required
                           class="{{ $errors->has('firstname') ? 'invalid' : '' }}" name="firstname"
                           value="{{ old('firstname') }}">
                    <x-input-error :field="'firstname'"/>
                </div>
            </div>

            <label for="email" class="required">@lang('form.email')</label>
            <input id="email" type="email" placeholder="@lang('form.placeholder.email')" required
                   class="{{ $errors->has('email') ? 'invalid' : '' }}"
                   name="email" value="{{ old('email') }}">
            <x-input-error :field="'email'"/>


            <label for="title" class="required">@lang('form.position')</label>
            <input id="position" type="text" placeholder="@lang('form.placeholder.position')" required
                   class="{{ $errors->has('position') ? 'invalid' : '' }}"
                   name="position"
                   value="{{ old('position') }}">
            <x-input-error :field="'position'"/>


            <div class="flex gap-6">
                <div class="basis-1/2">
                    <label for="mobile" class="required">@lang('form.mobile')</label>
                    <input id="mobile" type="text" placeholder="@lang('form.placeholder.mobile')" required
                           class="{{ $errors->has('mobile') ? 'invalid' : '' }}"
                           name="mobile" value="{{ old('mobile') }}">
                    <x-input-error :field="'mobile'"/>
                </div>


                <div class="basis-1/2">
                    <label for="telephone">@lang('form.phone_number')</label>
                    <input id="phone" type="text" placeholder="@lang('form.placeholder.phone')"
                           class="{{ $errors->has('phone') ? 'invalid' : '' }}" name="phone"
                           value="{{ old('phone') }}">
                    <x-input-error :field="'phone'"/>
                </div>
            </div>



            <label for="fax">@lang('form.fax')</label>
            <input id="fax" type="text" placeholder="@lang('form.placeholder.fax')"
                   class="{{ $errors->has('fax') ? 'invalid' : '' }}"
                   name="fax" value="{{ old('fax') }}">
            <x-input-error :field="'fax'"/>


        </x-card>


        <x-card class="my-8">

            <div class="text-riel-light mb-4 font-bold">
                @lang('pages/account.permissions')
            </div>

            @include('pages.customer-employees.includes.permissions', ['permissions' => $permissions])
        </x-card>

        <button type="submit" class="btn btn-primary mx-auto">@lang('pages/account.invite_employee')</button>
    </form>

@endsection

@section('sidebar')
    @include('includes.profile-menu', [
        'name' => 'profile'
    ])
@endsection
