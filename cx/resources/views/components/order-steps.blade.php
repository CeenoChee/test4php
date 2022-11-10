@php
    $cart = app('Cart');
@endphp
@if(!$cart->isEmpty())
    <div class="steps mb-4 scale-[0.85] xs:scale-100">
        <ul class="timeline flex">

            <li class="li complete">
                <a href="{{ LUrl::route('cart') }}">
                    <div class="icon">
                        <span><i class="fal fa-shopping-bag text-2lg text-riel-light"></i></span>
                    </div>
                    <div class="step-title">
                        <h4> @lang('pages/orders.cart')</h4>
                    </div>
                </a>
            </li>

            <li class="li @if(in_array($step, ['shipping', 'billing', 'checkout'])) complete @endif">
                @if(in_array($step, ['shipping', 'billing', 'checkout']))
                    <a href="{{ LUrl::route('billing') }}">
                        @endif

                        <div class="icon">
                            <span><i class="fal fa-file-invoice-dollar text-2lg text-riel-light"></i></span>
                        </div>
                        <div class="step-title">
                            <h4> @lang('pages/orders.billing') </h4>
                        </div>

                        @if(in_array($step, ['shipping', 'billing', 'checkout']))
                    </a>
                @endif
            </li>

            <li class="li @if(in_array($step, ['shipping', 'checkout'])) complete @endif">
                @if(in_array($step, ['shipping', 'checkout']))
                    <a href="{{ LUrl::route('shipping') }}">
                        @endif

                        <div class="icon">
                            <span><i class="fal fa-truck text-2lg text-riel-light"></i></span>
                        </div>
                        <div class="step-title">
                            <h4> @lang('pages/orders.shipping') </h4>
                        </div>

                        @if(in_array($step, ['shipping', 'checkout']))
                    </a>
                @endif
            </li>


            <li class="li @if($step == 'checkout') complete @endif">
                @if($step == 'checkout')
                    <a href="{{ LUrl::route('checkout') }}">
                        @endif
                        <div class="icon">
                            <span><i class="fal fa-file-invoice text-2lg text-riel-light"></i></span>
                        </div>
                        <div class="step-title">
                            <h4> @lang('pages/orders.checkout')</h4>
                        </div>
                        @if($step == 'checkout')
                    </a>
                @endif
            </li>

        </ul>
    </div>
@endif


{{--@if(!$cart->isEmpty())--}}
{{--    <ul class="grid grid-cols-4 xl:grid-cols-1  xl:grid-rows-4  text-center gap-8 mb-8 xl:mb-0">--}}
{{--        <li class="">--}}
{{--            <a href="{{ LUrl::route('cart') }}" class="mt-4">--}}
{{--                <i class="fal fa-shopping-bag w-16 h-16 md:w-24 md:h-24 text-xl md:text-3xl border border-solid border-neutral-500 rounded-full py-4 md:p-6 hover:bg-riel-light hover:text-white !leading-[1.1] @if($step === 'cart') bg-riel-light text-white border-sky-500 @endif"></i>--}}
{{--                <div class="mt-2">@lang('pages/orders.cart')</div>--}}
{{--            </a>--}}

{{--        </li>--}}
{{--        @if(!$cart->isEmpty())--}}
{{--            <li>--}}
{{--                <a href="{{ LUrl::route('shipping') }}">--}}
{{--                    <i class="fal fa-truck w-16 h-16 md:w-24 md:h-24 text-xl md:text-3xl border border-solid border-neutral-500 rounded-full py-4 md:p-6 hover:bg-riel-light hover:text-white !leading-[1.1] @if($step === 'shipping') bg-riel-light text-white border-sky-500 @endif"></i>--}}
{{--                    <div class="mt-2">@lang('pages/orders.shipping')</div>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @endif--}}
{{--        @if($cart->isValidShipping())--}}
{{--            <li>--}}
{{--                <a href="{{ LUrl::route('payment') }}">--}}
{{--                    <i class="fal fa-credit-card w-16 h-16 md:w-24 md:h-24 text-xl md:text-3xl border border-solid border-neutral-500 rounded-full py-4 md:p-6 hover:bg-riel-light hover:text-white !leading-[1.1] @if($step === 'payment') bg-riel-light text-white border-sky-500 @endif"></i>--}}
{{--                    <div class="mt-2">@lang('pages/orders.payment')</div>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @endif--}}
{{--        @if($cart->isValidPayment())--}}
{{--            <li>--}}
{{--                <a href="{{ LUrl::route('checkout') }}">--}}
{{--                    <i class="fal fa-file-invoice w-16 h-16 md:w-24 md:h-24 text-xl md:text-3xl border border-solid border-neutral-500 rounded-full py-4 md:p-6 hover:bg-riel-light hover:text-white !leading-[1.1] @if($step === 'checkout') bg-riel-light text-white border-sky-500 @endif"></i>--}}
{{--                    <div class="mt-2">@lang('pages/orders.checkout')</div>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        @endif--}}
{{--    </ul>--}}
{{--@endif--}}
