<div class="product-sum-box">
    <div class="wrapper">
        <div class="prices">
            <div class="status-label status-grey">
                @lang('global.summary')
            </div>
            <div class="price inactive">
                <div>@lang('global.products')</div>
                <div><span class="sum-price-text">{{ $invoice->getItemAmount() }}</span>
                    + @lang('global.vat')</div>
            </div>
            {{-- <div class="price inactive">
                <div>@lang('global.vat')</div>
                <div>{{ app('User')->getAfa() }} %</div>
            </div> --}}
        </div>
        <div class="buy">
            <div class="userprice sum-price-text"
                 data-label="@lang('global.summary_total')"
                 data-tax="+ @lang('global.vat')">
                {{ $invoice->getTotal() }}
            </div>
        </div>
    </div>
</div>
