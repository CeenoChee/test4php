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
    {{ Breadcrumbs::render('permissions.invite_employee', $customerEmployee) }}
@endsection

@section('right-content')


    <form method="POST" action="{{ route('employee.invite', [
                'locale' => app('Lang')->getLocale(),
                'customerId' => $customerEmployee->Ugyfel_ID,
                'customerEmployeeId' => $customerEmployee->UgyfelDolgozo_ID,
            ]) }}">
        @csrf
        <x-card>

            <div class="text-riel-light mb-4 font-bold">
                @lang('pages/account.personal_data')
            </div>

            <div class="formgrid">


                <label for="lastname">@lang('form.full_name')</label>
                <input type="text" disabled="disabled" class="form-control"
                       value="{{ $customerEmployee->Nev }}">


                <label for="email" class="required">@lang('form.email')</label>
                <input id="email" type="email" placeholder="@lang('form.placeholder.email')" required
                       class="{{ $errors->has('email') ? 'invalid' : '' }}"
                       name="email"
                       value="{{ old('email', $customerEmployee->MasodlagosEmail) }}">
                <x-input-error :field="'email'"/>


                <label for="position" class="required">@lang('form.position')</label>
                <input id="position" type="text" placeholder="@lang('form.placeholder.position')" required
                       class="{{ $errors->has('title') ? 'invalid' : '' }}"
                       name="position"
                       value="{{ old('position', $customerEmployee->Beosztas) }}">
                <x-input-error :field="'position'"/>


                <div class="flex gap-6">
                    <div class="basis-1/2">
                        <label for="mobile" class="required">@lang('form.mobile')</label>
                        <input id="mobile" type="text" placeholder="@lang('form.placeholder.mobile')" required
                               class="{{ $errors->has('mobile') ? 'invalid' : '' }}"
                               name="mobile"
                               value="{{ old('mobile', $customerEmployee->Mobil) }}">
                        <x-input-error :field="'mobile'"/>
                    </div>

                    <div class="basis-1/2">
                        <label for="phone">@lang('form.phone_number')</label>
                        <input id="phone" type="text" placeholder="@lang('form.placeholder.phone')"
                               class="{{ $errors->has('phone') ? 'invalid' : '' }}" name="phone"
                               value="{{ old('phone', $customerEmployee->Telefonszam) }}">
                    </div>
                </div>


                <label for="fax">@lang('form.fax')</label>
                <input id="fax" type="text" placeholder="@lang('form.placeholder.fax')"
                       class="{{ $errors->has('fax') ? 'invalid' : '' }}"
                       name="fax" value="{{ old('fax', $customerEmployee->Fax) }}">

            </div>
        </x-card>



        <x-card class="my-8">
            <div class="text-riel-light mb-4 font-bold">
                @lang('pages/account.permissions')
            </div>

            @include('pages.customer-employees.includes.permissions', ['permissions' => $permissions])
        </x-card>

        <button type="submit" class="btn mx-auto">
            @lang('pages/account.invite_employee')
        </button>

    </form>

@endsection

