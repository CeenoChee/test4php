@extends('layouts.app')

@section('head')
    <link href="{{ mix('css/order.css') }}" rel="stylesheet">
@endsection

@section('title')
    @lang('pages/orders.billing')
@endsection

@section('content_title')
    @lang('pages/orders.billing')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('billing') }}
@endsection

@section('sidebar')

@endsection

@section('content')

    <x-order-steps :step="'billing'"/>

    <x-card>
        <div id="payment-page">

            {!! Form::open(['route' => ['billing.save', 'locale' => app('Lang')->getLocale()]]) !!}


            <div class="text-center text-riel-dark text-3lg my-12 font-thin">@lang('pages/orders.billing_address')</div>

            <div id="addresses">
                <the-addresses
                    page="billing"
                    :initial-customer="{{ $customer }}"
                    :countries="{{ $countries }}"
                />
            </div>

            <div class="text-center text-riel-dark text-3lg my-12 font-thin">@lang('pages/orders.payment_method')</div>

            <div class="gap-4 md:justify-center md:flex">

                @if($cart->getShipmentCost()->is(\App\Libs\Enums\ShipmentCost::CUSTOMER))
                    <x-card
                        class="payment-item fuvar_vevo border border-solid border-neutral-200 text-center hover:cursor-pointer w-full md:w-[190px]">
                        <i class="fal fa-hand-holding-usd text-xl"></i>
                        {{ Form::radio('payment', \App\Libs\Enums\Payment::CASH, $payment->is(\App\Libs\Enums\Payment::CASH), ['id' => 'fizetesi_mod_keszpenz', 'class' => 'hidden']) }}
                        <label class="block form-check-label font-semibold" for="fizetesi_mod_keszpenz">
                            @lang('pages/orders.cash')
                        </label>
                    </x-card>
                @endif

                @if($canUseCreditCard)
                    <x-card
                        class="payment-item fuvar_vevo fuvar_szallito_dijmentes border border-solid border-neutral-200 text-center hover:cursor-pointer w-full md:w-[190px]">
                        <i class="fal fa-credit-card text-xl"></i>
                        {{ Form::radio('payment',  \App\Libs\Enums\Payment::CREDIT_CARD, $payment->is(\App\Libs\Enums\Payment::CREDIT_CARD) || !$canTransfer, ['id' => 'fizetesi_mod_bankkartya', 'class' => 'hidden mb-0']) }}
                        <label class="block form-check-label font-semibold" for="fizetesi_mod_bankkartya">
                            @lang('pages/orders.credit_card')
                        </label>
                    </x-card>
                @endif

                @if($cart->getShipmentCost()->is(\App\Libs\Enums\ShipmentCost::SUPPLIER_FREE) && !$isForeigner)
                    <x-card
                        class="payment-item fuvar_szallito_dijmentes border border-solid border-neutral-200 text-center hover:cursor-pointer w-full md:w-[190px]">
                        <i class="fal fa-hand-holding-usd text-xl"></i>
                        {{ Form::radio('payment', \App\Libs\Enums\Payment::CASH_ON_DELIVERY ,$payment->is(\App\Libs\Enums\Payment::CASH_ON_DELIVERY), ['id' => 'fizetesi_mod_utanvet', 'class' => 'hidden mb-0']) }}
                        <label class="block form-check-label font-semibold" for="fizetesi_mod_utanvet">
                            @lang('pages/orders.pay_on_delivery')
                        </label>
                    </x-card>
                @endif

                <x-card
                    class="payment-item fuvar_vevo fuvar_szallito_dijmentes border border-solid border-neutral-200 text-center hover:cursor-pointer w-full md:w-[190px]">
                    <i class="fal fa-money-check-alt text-xl"></i>
                    {{ Form::radio('payment', \App\Libs\Enums\Payment::PREPAYMENT , $payment->is(\App\Libs\Enums\Payment::PREPAYMENT), ['id' => 'fizetesi_mod_elorefizetes', 'class' => 'mb-0 hidden']) }}
                    <label class="block form-check-label font-semibold" for="fizetesi_mod_elorefizetes">
                        @lang('pages/orders.prepayment')
                    </label>
                </x-card>

                @if($canTransfer)
                    <x-card
                        class="payment-item fuvar_vevo fuvar_szallito_dijmentes border border-solid border-neutral-200 text-center hover:cursor-pointer w-full md:w-[190px]">
                        <i class="fal fa-money-check-edit-alt text-xl"></i>
                        {{ Form::radio('payment', \App\Libs\Enums\Payment::TRANSFER , $payment->is(\App\Libs\Enums\Payment::TRANSFER), ['id' => 'fizetesi_mod_atutalas', 'class' => 'mb-0 hidden']) }}
                        <label class="form-check-label block font-semibold" for="fizetesi_mod_atutalas">
                            @lang('pages/orders.transfer')
                        </label>
                    </x-card>
                @endif

            </div>

            @include('layouts.includes.field-error', [
                       'name' => 'payment'
                   ])


            <div id="simplepay-logo" class="my-4 hidden">
                <a href="http://simplepartner.hu/PaymentService/{{ (app('Lang')->getLocale() == 'hu' ? 'Fizetesi_tajekoztato.pdf' : 'Fizetesi_tajekoztato_EN.pdf') }}"
                   target="_blank">
                    <img src="{{ asset('assets/images/simplepay/simplepay_w240.png') }}" alt="SimplePay" class="mx-auto">
                </a>
            </div>

            <x-alert id="prepayment-text" class="my-4 alert-primary text-center hidden">
                <span class="font-bold">Előrefizetéses vásárlás esetén az egyedi tetélek beszerzését csak a összeg beérkezése után indítjuk el!</span>
            </x-alert>


            <button type="submit" class="btn mx-auto mt-8 !bg-green-500">
                @lang('form.next')
            </button>

            {!! Form::close() !!}
        </div>
    </x-card>
@endsection


@push('scripts')
    <script src="{{ mix('js/customer-premise.js') }}"></script>
@endpush
