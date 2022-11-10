@extends('layouts.app')

@section('title')
    @lang('pages/auth.register_summary')
@endsection

@section('content_title')
    @lang('pages/auth.register_summary')
@endsection

@section('meta_description')
    @lang('pages/auth.register_summary_meta_description')
@endsection

@section('content')
    <x-card class="w-full md:w-1/2 mx-auto">
        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.lastname'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Vezeteknev }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.firstname'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Keresztnev }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.position'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Beosztas }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.mobile'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Mobil }}
            </div>
        </div>

        @isset($user->Telefon)
        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.phone'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Telefon }}
            </div>
        </div>
        @endisset

        @isset($user->Fax)
        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.fax'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Fax }}
            </div>
        </div>
        @endisset

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.head_office'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->country->Nev }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.zip_code'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->IrSzam }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.city'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Helyseg }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.address'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->UtcaHSzam }}
            </div>
        </div>


        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.email'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->email }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.company_name'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Cegnev }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.company_tax_number'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Adoszam }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-right">
                @lang('form.company_registration_number'):
            </div>
            <div class="font-thin mb-1">
                {{ $user->Cegjegyzekszam }}
            </div>
        </div>
    </x-card>
@endsection
