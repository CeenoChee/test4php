<div class="product-sum-box top-[180px] w-[300px] right-0 bg-white p-4 pt-2 rounded-md ml-auto mt-8">

    <div class="prices">
        <div class="text-center uppercase text-neutral-400 mb-2 text-xs font-semibold">
            @lang('pages/orders.summary')
        </div>

        <hr>

        <table class="w-full table-fixed text-xs">
            <tr class="">
                <td class="text-neutral-500 pr-2 py-2 text-xs">@lang('pages/products.products'):</td>
                <td class="pl-2 py-2">
                    <span class="sum-price-text text-gray-500 font-semibold">{{ $order->getItemAmount() }}</span>
                    <span class="text-2xs text-gray-400">+ @lang('prices.vat')</span>
                </td>
            </tr>
            <tr class="">
                <td class="text-neutral-500 pr-2 py-2 text-xs">@lang('prices.shipping_price'):</td>
                <td class="pl-2 py-2">
                    <span
                        class="sum-price-text text-gray-500  shipping-price-text font-semibold">{{ $order->getShipmentAmount() }}</span>
                    <span class="text-2xs text-gray-400">+ @lang('prices.vat')</span>
                </td>
            </tr>
            <tr class="">
                <td class="text-neutral-500 pr-2 py-2 text-xs">@lang('prices.vat'):</td>
                <td class="pl-2 py-2">
                    <span class="text-gray-500 font-semibold">{{ app('User')->getAfa() }} %</span>
                    <span class="text-2xs text-gray-400">+ @lang('prices.vat')</span>
                </td>
            </tr>

        </table>

        <div class="border-t border-solid border-neutral-200 font-bold mb-4">
            <div class="text-neutral-500 pr-2 py-2 text-xs">@lang('pages/orders.summary_total'):</div>
            <div>
                <span class="sum-price-text text-riel-light text-2lg">{{ $order->getTotal()  }}</span>
                <span class="text-2xs text-gray-400">+ @lang('prices.vat')</span>
            </div>
        </div>


        <div id="simplepay-logo" class="my-4 hidden">
            <a href="http://simplepartner.hu/PaymentService/{{ (app('Lang')->getLocale() == 'hu' ? 'Fizetesi_tajekoztato.pdf' : 'Fizetesi_tajekoztato_EN.pdf') }}"
               target="_blank">
                <img src="{{ asset('assets/images/simplepay/simplepay_w240.png') }}" alt="SimplePay" class="mx-auto">
            </a>
        </div>


        @if(isset($checkout))
            <button type="submit"
                    class="btn !bg-green-500 !hover:bg-green-600 w-48 mx-auto">
                @if($order->getPayment()->is(\App\Libs\Enums\Payment::CREDIT_CARD))
                    @lang('form.next')
                @else
                    @lang('pages/orders.ordering')
                @endif
            </button>

        @endif

    </div>

</div>

