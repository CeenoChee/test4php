@extends('layouts.app')

@section('title')
    @lang('pages/orders.shipping')
@endsection

@section('content_title')
    @lang('pages/orders.shipping')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('shipping') }}
@endsection


@section('content')

    <x-order-steps :step="'shipping'"/>

    <div id="order-prices" data-url="{{ route('order.prices', ['locale' => app('Lang')->getLocale()]) }}"></div>
    <div id="shipping-page">
        {!! Form::open(['route' => ['shipping.save', 'locale' => app('Lang')->getLocale()], 'autocomplete' => "off", 'id' => 'shipping-form']) !!}
        <the-shipping
            :initial-pickup-locations="{{ $pickupLocations }}"
            :initial-customer="{{ $customer }}"
            :initial-address-picker-type="'{{ $addressPickerType }}'"
            :countries="{{ $countries }}"
            :initial-cart="{{ $cart }}"
            sub-total="{{ Fct::price($cart->getItemAmount()) }}"
            shipping-cost="{{ Fct::price($cart->getShipmentAmount()) }}"
            :vat="{{ app('User')->getAfa() }}"
            total="{{ Fct::price($cart->getTotal()) }}"
            order-prices-endpoint="{{ route('order.prices', ['locale' => app('Lang')->getLocale()]) }}"
            @if(!$errors->isEmpty())
            :errors="{{ $errors }}"
            @endif
        ></the-shipping>

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/shipping.js') }}"></script>
@endpush
