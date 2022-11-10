@extends('layouts.with-left-sidebar')

@section('head')
    <link href="{{ mix('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('title')
    @lang('pages/orders.orders')
@endsection

@section('content_title')
    @lang('pages/orders.orders')
@endsection

@section('meta_description')
    @lang('pages/orders.orders')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('my_orders') }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')
    <x-card>
        <div class="overflow-x-auto p-4">
            <table class="w-full py-1" id="orders-table">
                <thead>
                <tr class="border-b border-gray-500">
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/orders.order')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/orders.status')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/orders.payment')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    @php
                        $status = $order->getStatus();
                    @endphp
                    <tr class="border-b border-gray-200">
                        <td class="py-4 text-sm text-center text-gray-500">
                            <div>
                                @if($status->is(\App\Libs\Enums\OrderStatus::ARRIVED))
                                    <i class="fal fa-hourglass-half text-yellow-500 w-8 text-2lg"></i>
                                @elseif($status->is(\App\Libs\Enums\OrderStatus::TRANSPORTABLE))
                                    <i class="fal fa-truck text-orange-500 w-8 text-2lg"></i>{{-- Alternatív kocsi --}}
                                @elseif($status->is(\App\Libs\Enums\OrderStatus::RECEIVABLE))
                                    <i class="fal fa-hand-holding-box text-orange-500 w-8 text-2lg"></i>{{-- Csomagocska --}}
                                @elseif($status->is(\App\Libs\Enums\OrderStatus::IN_TRANSIT))
                                    <i class="fal fa-truck text-orange-500 w-8 text-2lg"></i>
                                @elseif($status->is(\App\Libs\Enums\OrderStatus::RECEIVED))
                                    <i class="fal fa-check text-green-500 w-8 text-2lg"></i>
                                @elseif($status->is(\App\Libs\Enums\OrderStatus::REJECTED))
                                    <i class="fal fa-times text-red-600 w-8 text-2lg"></i>
                                @elseif($status->is(\App\Libs\Enums\OrderStatus::DELIVERED))
                                    <i class="fal fa-check text-green-500 w-8 text-2lg"></i>
                                @endif

                                <a class="text-riel-light underline" href="{{ LUrl::routeOrder($order) }}">
                                    {{ $order->getNumber() }}
                                </a>
                            </div>
                        </td>
                        <td class="py-4 text-sm text-gray-500 scale-[0.85] order-timeline">
                            @if(!$status->is(\App\Libs\Enums\OrderStatus::REJECTED))
                                @include('pages.orders.includes.status-timeline', ['orderStatus' => $status])
                            @else
                                <div class="text-red-400">A rendelés elutasított vagy visszamondott</div>
                            @endif
                        </td>
                        <td class=" py-4 text-sm text-gray-500">
                            <div class="mb-2">
                                <i class="fal  @if($order->getShipmentCost() == trans('pages/orders.store')) fa-shop @else fa-truck @endif w-6 text-riel-light"></i> {{ $order->getShipmentCost() }}
                            </div>
                            <div>
                                <span class="text-riel-light text-lg font-bold">{{ $order->getTotal() }}</span> <span class="text-2xs">+ @lang('prices.vat')</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#orders-table').DataTable({
                language: {
                    url: "/assets/lang/datatable/hu.json"
                },
                order: [[0, "desc"]]
            });
        });
    </script>
@endpush
