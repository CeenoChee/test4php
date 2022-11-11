<div class="text-2xs text-gray-500 leading-none">
    @lang('pages/orders.summary_item_total')
</div>
<div class="font-bold">
                <span class="text-riel-light text-lg cart-item-price">
                    {{ Fct::price($prices->UgyfelAr->multiplication($cartItem->Mennyiseg)) }}
                </span>
    <span class="text-gray-500 text-2xs">+ @lang('prices.vat') </span>
</div>
