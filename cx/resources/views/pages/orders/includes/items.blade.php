<div class="overflow-x-auto">

    <table class="w-full rounded-md mt-8">
        <thead>
        <tr class="border-b border-gray-500">
            <th class="p-2 text-xs text-gray-500 uppercase text-left">@lang('pages/products.image')</th>
            <th class="p-2 text-xs text-gray-500 uppercase text-left">@lang('pages/products.product_name')</th>
            <th class="p-2 text-xs text-gray-500 uppercase">@lang('pages/orders.quantity')</th>
            <th class="p-2 text-xs text-gray-500 uppercase">@lang('pages/orders.shipping')</th>
            <th class="p-2 text-xs text-gray-500 uppercase text-right">@lang('prices.unit_price')</th>

            <th class="p-2 text-xs text-gray-500 uppercase text-right">@lang('pages/orders.item_total')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            @php
                $product = $item->getProduct();
                $deliveryTime = $item->getDeliveryTime();
                $status = $item->getStatus();
            @endphp

            <tr>
                <td rowspan="2" class="p-2 text-center">
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
                <td class="px-2 pt-2">
                    @if($product)
                        @if($product->manufacturer)
                            <div class="uppercase text-2xs">{{ $product->manufacturer->Nev }}</div>
                        @endif

                        <div>
                            @if($product->Aktiv)
                                <a href="{{ LUrl::routeProduct($product) }}" class="text-inherit">
                                    <div class="font-semibold">{{ $product->Kod }}</div>
                                </a>
                            @else
                                <div class="font-semibold">{{ $product->Kod }}</div>
                            @endif
                        </div>
                    @else
                        <div class="font-semibold text-gray-500">A termék már nem elérhető</div>
                    @endif
                </td>

                <td class="text-center bg-gray-100 rounded-bl-md text-xs">
                    @if($item->isItemCancelled())
                        <div class="line-through">
                            {{$item->getQty()}} @if($product && $product->unit){{ trim($product->unit->Nev) }}@endif
                        </div>
                    @endif

                    {{ $item->getQty() - $item->getCancelledQty()}} @if($product && $product->unit){{ trim($product->unit->Nev) }}@endif

                </td>

                <td class="text-center bg-gray-100">

                    <div class="text-xs leading-normal">
                        @if($deliveryTime->isEmpty())
                            <span class="italic text-gray-400">@lang('global.ask_about')</span>
                        @elseif($deliveryTime->isToday())
                            <span
                                class="border-b border-green-500">@lang('dates.today') @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                        @elseif($deliveryTime->isNextBusinessDay())
                            <span
                                class="border-b border-green-500">@lang('dates.next_business_day') @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                        @else
                            <span
                                class="border-b border-orange-500">{{ $deliveryTime->getDate() }} @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                        @endif
                    </div>

                    @if(count($item->getStatusItems()) > 1)

                        <div class="order-status-info relative w-fit mx-auto">
                            <i class="fa fa-circle-info text-riel-light"></i>

                            <div class="popup-wrapper">
                                <div class="popup">
                                    <div class="title">
                                        @lang('pages/orders.status')
                                    </div>
                                    @foreach($item->getStatusItems() as $state)
                                        @if($state->Mennyiseg != $item->getQty() )

                                            <div class="text-xs mt-2
                                            @if($state->Tipus == 0) text-red-400
                                            @elseif($state->Tipus == 1) text-white
                                            @elseif($state->Tipus == 2) text-green-600
                                            @endif">

                                                {{ $state->Mennyiseg }}
                                                @if($product->unit)
                                                    {{ trim($product->unit->Nev) }}
                                                @endif
                                                {{ $state->Nev }} {{ $state->Datum ?? '' }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    @endif

                </td>

                <td class="p-2 whitespace-nowrap text-right bg-gray-100 text-xs">
                    {{ $item->getCustomerPrice() }} <span class="text-2xs">+ @lang('prices.vat')</span>
                </td>


                <td class="p-2 whitespace-nowrap text-right bg-gray-100 rounded-br-md">
                    <span class="font-bold text-riel-light">{{ $item->getRowTotal() }}</span> <span
                        class="text-2xs">+ @lang('prices.vat')</span>
                </td>
            </tr>
            <tr class="border-b border-neutral-200">
                <td class="p-2">
                    <div class="text-2xs w-60">
                        {{ $product->trans->Nev }}
                    </div>
                </td>
                <td colspan="3">
                    @if(!isset($checkoutPage))
                        <div class="scale-[0.85] my-2">
                            @if(!$status->is(\App\Libs\Enums\OrderStatus::REJECTED))
                                @include('pages.orders.includes.status-timeline', ['orderStatus' => $status])
                            @else
                                <div class="text-red-400">A rendelés elutasított vagy visszamondott</div>
                            @endif
                        </div>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


