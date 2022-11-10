<button title="@lang('pages/comparison.compare')"
        class="leading-none right-0 p-2 rounded-md border compare-button bg-white compare-button-{{ $product->Termek_ID }} mb-4
            comparison-set @if(in_array($product->Termek_ID, session('comparison', []))) text-green-500 border-green-500 compared @else border-sky-500 text-riel-light @endif hover:text-riel-dark hover:border-riel-dark"
        data-url="{{ route('comparison.set', ['Termek_ID' => $product->Termek_ID, 'locale' => app('Lang')->getLocale()]) }}">

        <i class="comparison-icon fal fa-arrow-right-arrow-left"></i>

    <span class="text-xs">@lang('pages/comparison.compare')</span>

</button>
