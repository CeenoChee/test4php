@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/orders.order')
@endsection

@section('content_title')
    @lang('pages/orders.order')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('order_show', $order) }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    @include('pages.orders.includes.header', [
           'order' => $order
       ])

    <h2 class="text-center text-riel-dark text-3lg my-12 font-thin">{{ __('global.items') }}</h2>

    <x-card class="mt-4 order-timeline">
        @include('pages.orders.includes.items', [
            'items' => $order->getItems()
        ])


        @include('pages.orders.includes.summary', [
            'order' => $order
        ])
    </x-card>
@endsection

@push('scripts')
    <script>
        $(document).on({
            mouseenter: function () {
                $(this).find('.popup-wrapper').addClass('show');
            },
            mouseleave: function () {
                $(this).find('.popup-wrapper').removeClass('show');
            }
        }, '.order-status-info');
    </script>
@endpush
