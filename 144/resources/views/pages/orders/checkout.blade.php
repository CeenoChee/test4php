@extends('layouts.app')

@section('title')
    @lang('pages/orders.checkout')
@endsection

@section('content_title')
    @lang('pages/orders.checkout')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('checkout') }}
@endsection


@section('content')

    <x-order-steps :step="'checkout'"/>


    <h2 class="text-center text-riel-dark text-3lg my-12 font-thin">Rendelés adatai</h2>


    <div id="checkout">
        {!! Form::open(['route' => ['checkout.save', 'locale' => app('Lang')->getLocale()]]) !!}
        <div class="wrapper-box">

            @include('pages.orders.includes.header', [
                'order' => $order,
                'editable' => true
            ])

        </div>

        <h2 class="text-center text-riel-dark text-3lg my-12 font-thin">Tételek</h2>

        @if($errorMessages->getHeadMessages())
            @foreach($errorMessages->getHeadMessages() as $errorMessage)
                @include('layouts.includes.message', ['message' => $errorMessage, 'class' => 'alert-danger'])
            @endforeach
        @endif

        <x-card class="mt-4">
            <div class="prods">
                @include('pages.orders.includes.items', [
                           'items' => $order->getItems(),
                           'checkoutPage' => true,
                           'errorMessages' => $errorMessages
                       ])
            </div>


            @include('pages.orders.includes.summary', [
                'order' => $order,
                'checkout' => true
            ])
        </x-card>

        {!! Form::close() !!}
    </div>
@endsection

