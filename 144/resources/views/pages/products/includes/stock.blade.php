@if(Fct::isRielActive())
    @php
        $hq = 0;
        $warehouse = 0;
        $europe = 0;
        foreach ($product->stock as $stock) {
            if ($stock->Kod == 'KPR') $hq += $stock->SzabadMennyiseg;
            if ($stock->Kod == 'KHR') $warehouse += $stock->SzabadMennyiseg;
            if ($stock->Kod == 'TE-HIKEU') $europe += $stock->SzabadMennyiseg;
        }

        $isRiel = Fct::isRiel();

    @endphp

    <div class="uppercase text-gray-500 text-2xs text-center border-b-2 mb-2 {{ ($hq + $warehouse) > 0 ? 'border-green-500' : 'border-orange-500' }}">
        @lang('stocks.stock')
    </div>
    <div class="stock grid grid-cols-3 text-center divide-x">
        <div>
            <div class="text-2xs text-gray-400 leading-none">
                @lang('stocks.center')
            </div>
            <span class="text-xs">@if($isRiel){{ $hq }}@else{{ $hq > 20 ? '20+' : $hq }}@endif <span class="unit">@if($product->unit) {{ trim($product->unit->Nev) }}@endif</span></span>
        </div>
        <div>
            <div class="text-2xs text-gray-400 leading-none">
                @lang('stocks.warehouse')
            </div>
            <span class="text-xs">@if($isRiel){{ $warehouse }}@else{{ $warehouse > 20 ? '20+' : $warehouse }}@endif <span class="unit">@if($product->unit) {{ trim($product->unit->Nev) }}@endif</span></span>
        </div>
        @if($isRiel)
            <div>
                <div class="text-2xs text-gray-400 leading-none">
                    @lang('stocks.europe')
                </div>
                <span class="text-xs">{{ $europe }} <span class="unit">@if($product->unit) {{ trim($product->unit->Nev) }}@endif</span></span>
            </div>
        @endif
    </div>
@endif
