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

    <x-card>

    <div class="text-riel-light mb-4 font-bold">
        @lang('pages/account.personal_data')
    </div>

    <div class="grid grid-cols-2">

        <div class="text-gray-500 font-thin">@lang('form.full_name'):</div>
        <div>{{ $customerEmployee->Nev }}</div>

        <div class="text-gray-500 font-thin">@lang('form.email'):</div>
        <div>{{ $customerEmployee->MasodlagosEmail }}</div>

        <div class="text-gray-500 font-thin">@lang('form.position'):</div>
        <div>{{  $customerEmployee->Beosztas }}</div>

        <div class="text-gray-500 font-thin">@lang('form.mobile'):</div>
        <div>{{ $customerEmployee->Mobil }}</div>

        <div class="text-gray-500 font-thin">@lang('form.phone_number'):</div>
        <div>{{ $customerEmployee->Telefonszam }}</div>

        <div class="text-gray-500 font-thin">@lang('form.fax'):</div>
        <div>{{ $customerEmployee->Fax}}</div>
    </div>
    </x-card>

@endsection

