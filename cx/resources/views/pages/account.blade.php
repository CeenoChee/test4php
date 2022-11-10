@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/account.account')
@endsection

@section('content_title')
    @lang('pages/account.account')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('account') }}
@endsection


@section('top')
    @include('includes.profile-check-alert')
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    <div class="grid lg:grid-cols-2 gap-4">

        <x-card>

            <div class="text-riel-light mb-4 font-bold">
                @lang('form.personal_data')
            </div>

            <div class="grid grid-cols-2">

                <div class="text-gray-500 font-thin">@lang('form.name'):</div>
                <div>{{ $user->getName() }}</div>

                <div class="text-gray-500 font-thin">@lang('form.email'):</div>
                <div class="mb-2">
                    {{ $user->getEmail() }}<br/>
                    <a href="{{ LUrl::route('password.update') }}" class="text-riel-light">
                        <i class="fal fa-pen-to-square"></i> @lang('pages/auth.update_password')
                    </a>
                </div>

                <div class="text-gray-500 font-thin">@lang('form.position'):</div>
                <div>{{ $user->getPosition() }}</div>

                <div class="text-gray-500 font-thin">@lang('form.phone_number'):</div>
                <div>{{ $user->getPhone() }}</div>

                <div class="text-gray-500 font-thin">@lang('form.mobile'):</div>
                <div>{{ $user->getMobile() }}</div>

                @if($user->getFax())
                    <div class="text-gray-500 font-thin">@lang('form.fax'):</div>
                    <div>{{ $user->getFax() }}</div>
                @endif
            </div>

        </x-card>

        <x-card>

            <div class="font-bold text-riel-light mb-4">
                @lang('form.billing_address')
            </div>

            <div class="grid grid-cols-2">

                <div class="text-gray-500 font-thin">@lang('form.country'):</div>
                <div>{{ $user->getCountry()->Nev }}</div>

                <div class="text-gray-500 font-thin">@lang('form.zip_code'):</div>
                <div>{{ $user->getPostcode() }}</div>

                <div class="text-gray-500 font-thin">@lang('form.city'):</div>
                <div>{{ $user->getCity() }}</div>

                <div class="text-gray-500 font-thin">@lang('form.address'):</div>
                <div>{{ $user->getStreetHouseNumber() }}</div>

            </div>
        </x-card>
    </div>

    <div class="grid lg:grid-cols-2 gap-4 mt-4">

        @if($user->isRielActive())
            <x-card>
                <div class="font-bold text-riel-light mb-4">
                    @lang('pages/account.company_details')
                </div>

                <div class="grid grid-cols-2">

                    <div class="text-gray-500 font-thin">@lang('form.company_name'):</div>
                    <div>{{ $user->getCustomer()->Nev }}</div>

                    <div class="text-gray-500 font-thin">@lang('form.company_tax_number'):</div>
                    <div>{{ $user->getCustomer()->Adoszam }}</div>

                    <div class="text-gray-500 font-thin">@lang('form.company_registration_number'):</div>
                    <div>{{ $user->getCustomer()->Cegjegyzekszam }}</div>

                </div>
            </x-card>
        @endif

        @if($user->getCustomer() && $user->getCustomer()->agent)
            <x-card>

                <div class="font-bold text-riel-light mb-4">
                    @lang('pages/account.agent')
                </div>

                <div class="grid grid-cols-2">
                    <div class="text-gray-500 font-thin">@lang('form.name'):</div>
                    <div>{{ $user->getCustomer()->agent->Nev }}</div>

                    <div class="text-gray-500 font-thin">@lang('form.phone_number'):</div>
                    <div>{{ $user->getCustomer()->agent->Telefon }}</div>

                    <div class="text-gray-500 font-thin">@lang('form.email'):</div>
                    <div>{{ $user->getCustomer()->agent->Email }}</div>
                </div>
            </x-card>
        @endif
    </div>

@endsection

@section('sidebar')
    @include('includes.profile-menu', [
        'name' => 'profile'
    ])
@endsection
