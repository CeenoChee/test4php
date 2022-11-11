@extends('layouts.with-left-sidebar')

@section('title')
    @lang('pages/invoices.invoice')
@endsection

@section('content_title')
    {{ $invoice->getNumber() }}
@endsection


@section('breadcrumb')
    {{ Breadcrumbs::render('invoice', $invoice) }}
@endsection

@section('sidebar')
    @include('includes.profile-menu')
@endsection

@section('right-content')

    {{-- <x-card>
        <table class="w-full">
            <tr>
                <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">@lang('pages/invoices.customer_account_id')</td>
                <td class="py-2 pl-2 border-b border-gray-300">{{ $invoice->VevoSz_ID }}</td>
            </tr>
            <tr class="">
                <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">@lang('pages/invoices.invoice_number')
                    :
                </td>
                <td class="py-2 pl-2 border-b border-gray-300">{{ $invoice->getNumber() }}</td>
            </tr>
            @if($invoice->customer)
                <tr>
                    <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">@lang('pages/invoices.client')</td>
                    <td class="py-2 pl-2 border-b border-gray-300">{{ $invoice->customer->Nev }}</td>
                </tr>
            @endif
            @if($invoice->customerPremise)
                <tr>
                    <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">@lang('pages/account.customer_premise')
                        :
                    </td>
                    <td class="py-2 pl-2 border-b border-gray-300">{{ $invoice->customerPremise->getAddress() }}</td>
                </tr>
            @endif
            @if($invoice->customerEmployee)
                <tr>
                    <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">@lang('pages/invoices.client_administrator')</td>
                    <td class="py-2 pl-2 border-b border-gray-300">{{ $invoice->customerEmployee->Nev }}</td>
                </tr>
            @endif
            <tr>
                <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">
                    @lang('pages/orders.payment_method'):
                </td>
                <td class="py-2 pl-2 border-b border-gray-300">{{ $invoice->getPayment() }}</td>
            </tr>
            <tr>
                <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">@lang('dates.date')</td>
                <td class="py-2 pl-2 border-b border-gray-300">{{ $invoice->getFulfillmentDate() }}</td>
            </tr>
            @if($invoice->currency)
                <tr>
                    <td class="py-2 text-right pr-2 border-b border-gray-300 font-semibold">@lang('prices.currency')</td>
                    <td class="py-2 pl-2 border-b border-gray-300">{{ $invoice->currency->Nev }}</td>
                </tr>
            @endif
        </table>


        <div class="overflow-x-auto">

            <table class="mt-12 w-full">
                <thead>
                <tr class="bg-neutral-200">
                    <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/products.product_code')</th>
                    <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/products.product_name')</th>
                    <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('prices.unit_price')</th>
                    <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('prices.discount')</th>
                    <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/orders.quantity')</th>
                    <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/orders.item_total')</th>
                    <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('prices.vat')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoice->items as $invoiceItem)
                    @php $netUnitPrice = $invoiceItem->getNetUnitPrice(); @endphp
                    @if($invoiceItem->product)
                        <tr>
                            <td class="p-2">{{ $invoiceItem->product->Kod }}</td>
                            <td class="p-2 text-xs">{{ $invoiceItem->product->Nev }}</td>
                            <td class="p-2 text-center">{{ $netUnitPrice }}</td>
                            <td class="p-2 text-center">{{ $invoiceItem->EngedmenySzazalek }} {{ '%' }}</td>
                            <td class="p-2 text-center">{{ $invoiceItem->Mennyiseg}} {{ $invoiceItem->product->unit->Nev }}</td>
                            <td class="p-2 text-center">{{ $netUnitPrice->multiplication($invoiceItem->Mennyiseg) }}</td>
                            <td class="p-2 text-center">{{ $invoiceItem->AfaKulcs }} {{ '%' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="p-2"></td>
                            <td class="p-2">{{ $invoiceItem->Szoveg }}</td>
                            <td class="p-2">{{ $netUnitPrice }}</td>
                            <td class="p-2">{{ $invoiceItem->EngedmenySzazalek }} {{ '%' }}</td>
                            <td class="p-2">{{ $invoiceItem->Mennyiseg}} db</td>
                            <td class="p-2">{{ $netUnitPrice->multiplication($invoiceItem->Mennyiseg) }}</td>
                            <td class="p-2">{{ $invoiceItem->AfaKulcs }} {{ '%' }}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </x-card> --}}




    <h2 class="text-center text-riel-dark text-3lg mb-12 font-thin">{{ __('pages/invoices.invoice_details') }}</h2>


    @include('pages.invoices.includes.header', [
           'invoice' => $invoice
       ])

    <h2 class="text-center text-riel-dark text-3lg mb-12 font-thin mt-12">{{ __('global.items') }}</h2>

    <x-card class="mt-4">
        @include('pages.invoices.includes.items', [
            'items' => $invoice->items
        ])


        @include('pages.invoices.includes.summary', [
            'invoice' => $invoice
        ])
    </x-card>
@endsection



