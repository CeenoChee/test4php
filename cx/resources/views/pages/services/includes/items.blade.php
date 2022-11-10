
<div class="overflow-x-auto">

    <table class="mt-12 w-full">
        <thead>
        <tr class="bg-neutral-200">
            <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/products.image')</th>
            <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/services.type')</th>
            <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/services.denomination')</th>
            <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/orders.quantity')</th>
            <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('prices.unit_price')</th>
            <th class="px-6 py-2 text-xs text-gray-500 uppercase">@lang('pages/services.value')</th>
        </tr>
        </thead>
        <tbody>


        @foreach($items as $item)
            @php
                $product = $item->product;
            @endphp
            <tr>
                <td class="p-2">
                    @if($product->Aktiv)
                        <a href="{{ LUrl::routeProduct($product) }}">
                            @include('pages.products.includes.main-image', [
                                'product' => $product,
                                'size' => 'product-small',
                                'mode' => 'bg'
                            ])
                        </a>
                    @else
                        <div>
                            @include('pages.products.includes.main-image', [
                                'product' => $product,
                                'size' => 'product-small',
                                'mode' => 'bg'
                            ])
                        </div>
                    @endif
                </td>

                <td class="p-2"> <!-- Tipus -->
                    @if($product->manufacturer)
                        {{ $product->manufacturer->Nev }} -
                    @endif
                    {{ $product->Kod }}
                </td>
                <td class="p-2"> <!-- Megnevezés -->
                    {{ $product->trans->Nev }}
                </td>
                <td class="p-2  text-center"> <!-- Mennyiség -->
                    @if(!$item->Garancialis)
                        {{ $item->Mennyiseg }}  {{ $product->unit->Nev }}
                    @endif
                </td>
                <td class="p-2 whitespace-nowrap text-right"> <!-- Egységár -->
                    @if(!$item->Garancialis)
                        @lang('prices.discounted_price')
                        {{ ($item->getNetUnitPrice()) }} <span class="text-2xs">+ @lang('prices.vat')</span>
                    @endif
                </td>
                <td class="p-2 whitespace-nowrap text-right"> <!-- Érték -->
                    @if($item->Garancialis)
                        {{ 'Garanciális' }}
                    @else
                        {{ ($item->getNetPrice()) }} <span class="text-2xs">+ @lang('prices.vat')</span>
                    @endif
                </td>
            </tr>
        @endforeach


        </tbody>
    </table>
</div>
