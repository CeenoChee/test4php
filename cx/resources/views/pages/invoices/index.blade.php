@extends('layouts.with-left-sidebar')

@section('head')
    <link href="{{ mix('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('title')
    @lang('pages/invoices.invoices')
@endsection

@section('content_title')
    @lang('pages/invoices.invoices')
@endsection


@section('breadcrumb')
    {{ Breadcrumbs::render('invoices') }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    {{-- <x-card>

        <div class="overflow-x-auto p-4">
            <table class="w-full py-1" id="invoice-table">
                <thead class="bg-gray-100">
                <tr class="bg-neutral-200">
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/invoices.invoice_number')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/invoices.status')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/invoices.payment')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td class="px-6 py-4 text-sm text-center text-gray-500">
                            {{ $invoice->getNumber() }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="mb-2">
                                <i class="fal fa-video w-6"></i>
                                {{ Fct::date($invoice->getFulfillmentDate()) }}
                            </div>
                            <div>
                                <i class="fal fa-calendar w-6"></i>
                                @if($invoice->EsedekessegDatum < date("Y-m-d") && $invoice->Statusz != 0 && $invoice->Statusz > 0)
                                    @lang('pages/invoices.overdue_invoice')
                                @elseif($invoice->Statusz <= 0)
                                    @lang('pages/invoices.paid_invoice')
                                @else
                                    @lang('pages/invoices.unpaid_invoice')
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="mb-2">
                                <i class="fal fa-scanner w-6"></i>
                                {{ $invoice->getPayment() }}
                            </div>
                            <div>
                                <i class="fal fa-shopping-bag w-6"></i>
                                {{ $invoice->Vegosszeg }} {{ 'Ft' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-center text-gray-500">
                            <div>
                                <a class="btn-outline"
                                   href="{{ $invoice->getShowRoute() }}"
                                >@lang('global.view')
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </x-card> --}}

    <x-card>
        <div class="overflow-x-auto p-4">
            <table class="w-full py-1" id="invoices-table">
                <thead>
                <tr class="border-b border-gray-500">
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/invoices.invoice_number')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/invoices.status')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('pages/invoices.payment')</th>
                    <th class="px-6 py-4 before:py-2 after:py-2  text-xs text-gray-500 uppercase">@lang('media.download')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr class="border-b border-gray-200">
                        <td class="py-4 text-sm text-center text-gray-500">
                            <a class="text-riel-light underline" href="{{ $invoice->getShowRoute() }}">
                                {{ $invoice->getNumber() }}
                            </a>
                        </td>
                        <td class="py-4 text-sm text-gray-500">
                            <div class="mb-2">
                                <i class="fal fa-video w-6 text-riel-light"></i>
                                {{ Fct::date($invoice->getFulfillmentDate()) }}
                            </div>
                            <div>
                                <i class="fal fa-calendar w-6 text-riel-light"></i>
                                @if($invoice->EsedekessegDatum < date("Y-m-d") && $invoice->Statusz != 0 && $invoice->Statusz > 0)
                                    @lang('pages/invoices.overdue_invoice')
                                @elseif($invoice->Statusz <= 0)
                                    @lang('pages/invoices.paid_invoice')
                                @else
                                    @lang('pages/invoices.unpaid_invoice')
                                @endif
                            </div>
                        </td>
                        <td class=" py-4 text-sm text-gray-500">
                            <div class="mb-2">
                                @php
                                    $payment = $invoice->getPayment();

                                    switch ($payment->getKey()) {
                                        case 'CHECK':
                                            $class = 'fa-money-check-alt';
                                            break;
                                        case 'CASH':
                                        case 'CASH_ON_DELIVERY':
                                            $class = 'fa-money-bill';
                                            break;
                                        case 'CREDIT_CARD':
                                        case 'ON_THE_SPOT_WITH_CREDIT_CARD':
                                            $class = 'fa-credit-card';
                                            break;
                                        default:
                                            $class = 'fa-credit-card-front';
                                            break;
                                    }
                                @endphp
                                <i class="fal {{ $class }} w-6 text-riel-light"></i>
                                {{ $invoice->getPayment() }}
                            </div>
                            <div>
                                <span class="text-riel-light text-lg font-bold">{{ $invoice->getTotal() }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if ($invoice->SzamlaPdf)
                                <div class="flex justify-center">
                                    <a href="{{ $invoice->getPdfRoute() }}" class="btn-green-500 font-bold w-fit" target="_blank">
                                        <i class="fal fa-download mr-2"></i>
                                        {{ __('media.download') }}
                                    </a>
                                </div>
                            @else
                                <span class="text-neutral-300"><i>Nem e-számla</i></span>
                            @endif
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
            $('#invoices-table').DataTable({
                language: {
                    url: "/assets/lang/datatable/hu.json"
                },
                order: [[0, "desc"]]
            });
        });
    </script>
@endpush
