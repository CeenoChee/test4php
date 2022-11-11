@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/services.repair')
@endsection

@section('content_title')
    {{ $serviceCertificate->getNumber() }}
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('service', $serviceCertificate) }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    <x-card>

        @include('pages.services.includes.header')

        @if($serviceCertificate->visibleItems())
            @include('pages.services.includes.items', [
                 'items' => $serviceCertificate->serviceCertificateEventItems
             ])
        @endif


        @if($serviceCertificate->getNetAmount()->getTotal() > 0 )
            @include('pages.services.includes.summary', [
                'serviceCertificate' => $serviceCertificate,
            ])
        @endif

    </x-card>
@endsection
