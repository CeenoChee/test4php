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
                    <span class="sum-price-text text-gray-500 font-semibold">{{ $invoice->getItemAmount() }}</span>
                    <span class="text-2xs text-gray-400">+ @lang('prices.vat')</span>
                </td>
            </tr>
            @foreach ($invoice->getVatValues() as $vat => $vatValue)
                <tr class="">
                    <td class="text-neutral-500 pr-2 py-2 text-xs">{{ $vat }}% @lang('prices.vat'):</td>
                    <td class="pl-2 py-2">
                        <span class="text-gray-500 font-semibold">{{ $vatValue }}</span>
                    </td>
                </tr>
            @endforeach

        </table>

        <div class="border-t border-solid border-neutral-200 font-bold mb-4">
            <div class="text-neutral-500 pr-2 py-2 text-xs">@lang('pages/orders.summary_total'):</div>
            <div>
                <span class="sum-price-text text-riel-light text-2lg">{{ $invoice->getTotal()  }}</span>
                <span class="text-2xs text-gray-400">+ @lang('prices.vat')</span>
            </div>
        </div>

    </div>

</div>

