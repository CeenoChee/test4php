@if(Fct::isRielActive())
    @if(($product->Kifuto || $product->KeszletErejeig) && $product->getStock() == 0)
        <div class="text-center text-gray-400 text-lg">
            @lang('pages/products.not_available')
        </div>
    @else

        @include('pages.products.includes.stock', [
            'product' => $product
        ])

        <div class="delivery-time-block pb-2 mb-2 border-b border-neutral-200 flex justify-center"
             data-url="{{ route('product.delivery.time', ['locale' => app('Lang')->getLocale(), 'Termek_ID' => $product->Termek_ID]) }}">
            @php $cart = app('Cart'); @endphp
            @include('pages.products.includes.delivery-time', [
                'product' => $product,
                'qty' => $cart->inCart($product) ? $cart->getQty($product) : 1
            ])
        </div>

        @php $prices = $product->getPrices(); @endphp
        @if($prices->UgyfelAr)
            <div class="wrapper text-center sm:text-left">
                @if($prices->ListaAr != $prices->UgyfelAr)

                    <div class="prices">
                        <div class="price mb-1 flex">
                            <div class="text-2xs text-gray-500 leading-none w-16">@lang('prices.list_price')</div>
                            <div class="grow text-right text-xs @if($prices->AkciosAr) line-through @endif">
                                {{ Fct::price($prices->ListaAr) }} <span
                                    class="text-gray-500 text-2xs">+ @lang('prices.vat')</span>
                            </div>
                        </div>
                        @if($prices->AkciosAr)
                            <div class="price flex mb-1 flex">
                                <div class="text-2xs text-gray-500 leading-none w-16">@lang('prices.sale_price')</div>
                                <div class="grow text-right text-xs">{{ Fct::price($prices->AkciosAr) }} <span
                                        class="text-gray-500 text-2xs">+ @lang('prices.vat')</span></div>
                            </div>

                        @endif
                        @if(Fct::isReseller())
                            <div
                                class="price telepitoi-ar mb-1 flex @if(Fct::installerPrice()) block @else hidden @endif">
                                <div
                                    class="text-2xs text-gray-500 leading-none w-16">@lang('prices.installer_price')</div>
                                <div class="grow text-right text-xs">{{ Fct::price($prices->TelepitoiAr) }} <span
                                        class="text-gray-500 text-2xs">+ @lang('prices.vat')</span></div>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="mt-4">

                    <div class="text-2xs text-gray-500 leading-none">
                        @lang($prices->ListaAr == $prices->UgyfelAr ? 'prices.fix_price' : 'prices.discounted_price')
                    </div>

                    <div class="font-bold mb-2 @if(isset($show)) text-3lg mt-2 @else text-lg @endif text-riel-light">
                        {{ Fct::price($prices->UgyfelAr) }} <span
                            class="text-gray-500 text-2xs">+ @lang('prices.vat')</span>
                    </div>

                </div>

                @if(Fct::isCanOrder() && ($product->getStockLimit() === null || $product->getStockLimit() > 0))
                    <div class="">
                        <div class="text-2xs text-gray-500">
                            @lang('pages/orders.quantity') @if($product->unit) ({{ trim($product->unit->Nev) }}) @endif:
                        </div>

                        @include('pages.products.includes.add-to-cart', [
                            'product' => $product
                        ])

                    </div>
                @endif

            </div>

        @else
            <div class="text-gray-500 text-center mt-4">
                @lang('prices.no_price')
            </div>
        @endif
    @endif
@else
    @if(auth()->user() && !auth()->user()->verified)
        @lang('prices.unverified_price')
    @else
        <div class="text-gray-500 text-center mt-4">
            @lang('prices.protected_price')
        </div>
    @endif
@endif
