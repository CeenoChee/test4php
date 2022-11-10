@extends('layouts.app')

@section('title')
    @lang('pages/orders.thank_you')
@endsection

@section('content_title')
    @lang('pages/orders.thank_you')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('thank_you') }}
@endsection

@section('content')

        <div id="checkout">

            <h2 class="text-center text-riel-dark text-3lg my-12 font-thin">Rendelés adatai</h2>

            <div class="wrapper-box">
                @include('pages.orders.includes.header', [
                    'order' => $order
                ])
            </div>

            <h2 class="text-center text-riel-dark text-3lg my-12 font-thin">Tételek</h2>

            <x-card>
            <div class="prods">
                @include('pages.orders.includes.items', [
                        'items' => $order->getItems(),

                    ])
            </div>

            @include('pages.orders.includes.summary', [
                'order' => $order
            ])
            </x-card>
        </div>

@endsection

