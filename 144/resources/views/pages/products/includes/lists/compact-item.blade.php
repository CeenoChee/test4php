<x-card class="px-6 border border-neutral-200">


    <div class="prod-item flex flex-col h-fit" data-prod-id="{{ $product->Termek_ID }}"
         data-prod-code="{{ $product->Kod }}">

        <div class="prod-base">

            <div class="w-fit ml-auto">

                @if(Fct::isRielActive() && $product->isSale() && $product->price->sale->first())
                    <a class="leading-none right-0 p-2 rounded-full border bg-red-600 border-red-600 text-white inline-block w-[32px] hover:text-white text-center"
                       href="{{ $product->price->sale->first()->link }}"
                       title="{{ $product->price->sale->first()->name }}">
                        <i class="fa fa-percent"></i>
                    </a>
                @endif


                <button title="@lang('pages/comparison.compare')"
                        class="leading-none right-0 p-2 rounded-full border compare-button bg-white compare-button-{{ $product->Termek_ID }}
                            comparison-set @if(in_array($product->Termek_ID, session('comparison', []))) text-green-500 border-green-500 compared @else border-sky-500 text-riel-light @endif hover:text-riel-dark hover:border-riel-dark"
                        data-url="{{ route('comparison.set', ['Termek_ID' => $product->Termek_ID, 'locale' => app('Lang')->getLocale()]) }}">

                    <i class="comparison-icon fal fa-arrow-right-arrow-left"></i>

                </button>

            </div>


            <div class="prod-image justify-center flex">
                <a class="image-s" href="{{ LUrl::routeProduct($product) }}">
                    @include('pages.products.includes.main-image', [
                        'product' => $product,
                        'size' => 'product-small',
                        'mode' => 'bg'
                    ])
                </a>
            </div>
            <div class="uppercase text-xs font-thin">{{ $product->manufacturer->Nev }}</div>
            <div class="model">
                <a href="{{ LUrl::routeProduct($product) }}" class="text-inherit">
                    <div class="font-semibold grow">{{ $product->Kod }}</div>
                    <div class="font-thin font-xs truncate">{{ $product->trans->Nev }}</div>

                </a>
            </div>
        </div>


        <div class="prod-data mt-2">

            @if(Fct::isRielActive())
                @if($product->Kifuto && $product->getStock() == 0)
                    <div class="wrapper">
                        <div class="notloggedin">
                            @lang('pages/products.not_available')
                        </div>
                    </div>
                @else
                    @php $prices = $product->getPrices(); @endphp
                    @if($prices->UgyfelAr)

                        <div class="text-2xs text-gray-500 leading-none">
                            @lang($prices->ListaAr == $prices->UgyfelAr ? 'prices.fix_price' : 'prices.discounted_price')
                        </div>

                        <div class="text-lg text-riel-light font-bold">
                            {{ Fct::price($prices->UgyfelAr) }} <span
                                class="text-xs text-gray-500">+ @lang('prices.vat')</span>
                        </div>
                        @if(Fct::isCanOrder() && ($product->getStockLimit() === null || $product->getStockLimit() > 0))
                            <div class="text-2xs">
                                @lang('pages/orders.quantity') (@if($product->unit){{trim($product->unit->Nev)}}@endif):
                            </div>
                            @include('pages.products.includes.add-to-cart', [
                                'product' => $product
                            ])
                        @endif

                    @else
                        <div class="text-gray-500 font-semibold">
                            @lang('prices.no_price')
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>
</x-card>
