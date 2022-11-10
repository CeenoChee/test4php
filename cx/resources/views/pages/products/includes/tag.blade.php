<div class="tag flex relative gap-2 mb-2">
    @if(Fct::isRielActive() && $product->isSale() && $product->price->sale->first())
        <div class="text sale bg-red-600 rounded-md py-1 px-2 text-white text-xs">
            <a href="{{ $product->price->sale->first()->link }}" class="hover:text-white">
                {{ $product->price->sale->first()->name }}
            </a>
            <div class="popup-wrapper">
                <div class="popup">
                    <div class="title">
                        {{ str_replace('-', '.', $product->price->sale->first()->DatumTol) }}. -
                        @if($product->price->sale->first()->DatumIg == '9999-12-31')
                            @lang('pages/products.until_cancellation')
                        @else
                            {{ str_replace('-', '.', $product->price->sale->first()->DatumIg)  }}.
                        @endif
                    </div>
                    {{ strip_tags($product->price->sale->first()->condition) }}
                </div>
            </div>
        </div>
    @endif


    @if($product->Ujdonsag)
        <div
            class="rounded-md py-1 px-2 bg-sky-200 text-gray-600 border border-gray-300 text-xs">@lang('pages/products.news')</div>
    @endif
    @if($product->Projekt)
        <div
            class="rounded-md py-1 px-2 bg-sky-200 text-gray-600 border border-gray-300 text-xs">@lang('pages/products.project')</div>
    @endif
    @if(Fct::isRielActive() && $product->Kifuto)
        <div
            class="rounded-md py-1 px-2 bg-sky-200 text-gray-600 border border-gray-300 text-xs">@lang('pages/products.discontinued')</div>
    @endif

    @if(Fct::isRielActive() && $product->KeszletErejeig)
        <div class="rounded-md py-1 px-2 bg-sky-200 text-gray-600 border border-gray-300 text-xs">@lang('pages/products.while_stocks_last')</div>
    @endif
</div>
