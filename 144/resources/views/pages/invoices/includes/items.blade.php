<div class="overflow-x-auto">

    <table class="w-full rounded-md mt-8">
        <thead>
        <tr class="border-b border-gray-500">
            <th class="p-2 text-xs text-gray-500 uppercase text-left">{{ __('pages/products.image') }}</th>
            <th class="p-2 text-xs text-gray-500 uppercase text-left">{{ __('pages/products.product_name') }}</th>
            <th class="p-2 text-xs text-gray-500 uppercase">{{ __('pages/orders.quantity') }}</th>
            <th class="p-2 text-xs text-gray-500 uppercase">{{ __('prices.discount') }}</th>
            <th class="p-2 text-xs text-gray-500 uppercase text-right">{{ __('prices.unit_price') }}</th>
            <th class="p-2 text-xs text-gray-500 uppercase text-right">{{ __('pages/orders.item_total') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            @php
                $product = $item->getProduct();
            @endphp

            <tr class="border-b border-neutral-200">
                <td class="p-2 text-center">
                    @if($product)
                        @if($product->Aktiv)
                            <a href="{{ LUrl::routeProduct($product) }}" class="image-m">
                                @include('pages.products.includes.main-image', [
                                    'product' => $product,
                                    'size' => 'product-small',
                                    'mode' => 'bg',
                                    'list' => true
                                ])
                            </a>
                        @else
                            <div class="image-m">
                                @include('pages.products.includes.main-image', [
                                    'product' => $product,
                                    'size' => 'product-small',
                                    'mode' => 'bg',
                                     'list' => true
                                ])
                            </div>
                        @endif

                    @else
                        <img src="{{ asset('assets/images/product/no_image.png') }}"
                             class="mx-auto w-[80px] product-image">
                    @endif
                </td>
                <td class="p-2">
                    @if($product)
                        @if($product->manufacturer)
                            <div class="uppercase text-2xs">{{ $product->manufacturer->Nev }}</div>
                        @endif

                        <div>
                            @if($product->Aktiv)
                                <a href="{{ LUrl::routeProduct($product) }}" class="text-inherit">
                                    <div class="font-semibold">{{ $product->Kod }}</div>
                                    <div class="text-2xs">
                                        {{ $product->trans->Nev }}
                                    </div>
                                </a>
                            @else
                                <div class="font-semibold">{{ $product->Kod }}</div>
                                <div class="text-2xs">
                                    {{ $product->trans->Nev }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="font-semibold text-gray-500">A termék már nem elérhető</div>
                    @endif
                </td>

                <td class="p-2 text-center">
                    {{ $item->getQuantity() }} @if($product && $product->unit){{ trim($product->unit->Nev) }}@endif
                </td>

                <td class="p-2 text-center">
                    {{ $item->getDiscount() }}
                </td>

                <td class="p-2 whitespace-nowrap text-right">
                    {{ $item->getNetUnitPrice() }} <span class="text-2xs">+ {{ __('prices.vat') }}</span>
                </td>

                <td class="p-2 whitespace-nowrap text-right">
                    <span class="font-semibold text-riel-light">{{ $item->getRowTotal() }}</span>
                    <span class="text-2xs">+ {{ __('prices.vat') }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

