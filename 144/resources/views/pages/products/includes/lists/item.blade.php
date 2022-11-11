
<div class="rounded-md prod-item md:flex shadow-md bg-white border border-solid border-neutral-200 mb-8 p-4" data-prod-id="{{ $product->Termek_ID }}"
     data-prod-code="{{ $product->Kod }}">

    <div class="basis-3/4 xl:basis-2/3 flex md:border-r border-neutral-200">
        <div class="prod-image">
            <a class="image-m" href="{{ LUrl::routeProduct($product) }}">
                @include('pages.products.includes.main-image', [
                    'product' => $product,
                    'size' => 'product-small',
                    'mode' => 'bg'
                ])
            </a>
        </div>

        <div class="px-4 w-full">
            <div class="uppercase text-xs font-thin">{{ $product->manufacturer->Nev }}</div>

                <div class="flex">

                    <a class="text-lg font-semibold grow text-inherit" href="{{ LUrl::routeProduct($product) }}">
                        {{ $product->Kod }}
                    </a>

                </div>

                <div>
                    <div class="mb-2 pr-8">{{ $product->trans->Nev }}</div>
                    @include('pages.products.includes.tag', [
                        'product' => $product
                    ])
                    <div class="text-gray-500 font-thin text-xs mb-4">
                        <div>
                            @if($product->Garancia)
                                @lang('pages/warranties.warranty'): {{ Fct::warranty($product->Garancia) }}
                            @endif
                        </div>
                        @foreach($product->getProductAttributes()->limit(3)->extra($extraProperties)->get() as $productAttribute)
                            <div>
                                {{ $productAttribute->getName() }}: {{ $productAttribute->getValue() }}
                            </div>
                        @endforeach

                        @if($product->trans)
                            <div class="overflow-hidden text-ellipsis max-h-28">
                                {!! $product->trans->Leiras !!}
                            </div>
                        @endif

                    </div>

                    <div class="">
                        @include('pages.comparison.includes.button', ['product' => $product])
                    </div>
                </div>
            </div>
    </div>
    <div class="prod-data basis-2/4 xl:basis-1/3 pl-4">
        @include('pages.products.includes.info-box', [
            'product' => $product
        ])
    </div>
</div>
