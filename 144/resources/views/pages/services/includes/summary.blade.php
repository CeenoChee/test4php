
<table class="w-full table-fixed">
    <tr class="border-b border-solid border-neutral-200">
        <td class="text-right text-neutral-500 pr-2 py-2 text-xs">@lang('pages/orders.summary_total'):</td>
        <td class="pl-2 py-2 font-bold">
            <span class="sum-price-text text-riel-light text-2lg">{{ $serviceCertificate->getNetAmount() }}</span>
            <span class="text-2xs text-gray-400">+ @lang('prices.vat')</span>
        </td>
    </tr>
</table>



