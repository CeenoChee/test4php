@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/account.addresses')
@endsection

@section('content_title')
    @lang('pages/account.addresses')
@endsection


@section('breadcrumb')
    {{ Breadcrumbs::render('addresses') }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    <div id="addresses">
        <x-card id="customer-premise">

            <h2 class="text-riel-light mb-4 font-bold">
                @lang('pages/orders.billing_addresses')
            </h2>


            <the-addresses
                page="premises"
                :initial-customer="{{ $customer }}"
                :countries="{{ $countries }}"
            />
        </x-card>


        <x-card id="shipping-page">

            <h2 class="text-riel-light mb-4 font-bold">
                @lang('pages/account.shipping_addresses')
            </h2>

            <the-addresses
                page="addresses"
                :initial-customer="{{ $customer }}"
                :countries="{{ $countries }}"
            />
        </x-card>
    </div>



@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@push('scripts')
    <script src="{{ mix('js/customer-premise.js') }}"></script>
@endpush
