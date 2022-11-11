@php
    $product = $cartItem->product;
    $prices = $product->getPrices();
    $messages = $errorMessages->getItemMessages($cartItem->Termek_ID);
@endphp


<div class="my-2 bg-white rounded-md shadow-md prod-item md:flex py-4">

    <div class="md:basis-4/6 lg:basis-2/6 px-4 flex">

        <div class="mr-4">
            <a href="{{ LUrl::routeProduct($product) }}">
                @include('pages.products.includes.main-image', [
                    'product' => $product,
                    'size' => 'product-small',
                    'mode' => 'bg'
                ])
            </a>
        </div>

        <div>
            <div class="uppercase text-2xs font-thin">{{ $product->manufacturer->Nev }}</div>

            <a href="{{ LUrl::routeProduct($product) }}" class="text-inherit">
                <div class="font-semibold">{{ $product->Kod }}</div>
            </a>
            <div class="delivery-time-block"
                 data-url="{{ route('product.delivery.time', ['locale' => app('Lang')->getLocale(), 'Termek_ID' => $product->Termek_ID]) }}">
                @include('pages.products.includes.delivery-time', [
                    'product' => $product,
                    'qty' => $cartItem->Mennyiseg
                ])
            </div>
        </div>


        @if(isset($messages))
            <ul class="italic text-xs text-gray-500 mt-2">
                @foreach($messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif

    </div>


    <div class="md:basis-1/6 px-4 self-center hidden lg:block">

        @include('pages.cart.includes.item-price')

    </div>


    <div class="basis-2/6 md:basis-4/6 lg:basis-2/6 px-4 items-center mt-4 md:mt-0">

        <div class="text-2xs text-gray-500">
            @lang('pages/orders.quantity') (@if($product->unit){{trim($product->unit->Nev)}}@endif):
        </div>
        <div class="cart cart-form relative  @if($product->KeszletErejeig) while-stocks-last @endif">

            <div class="flex">
                @if($product->KeszletErejeig)
                    <x-popup :title="'Készlet erejéig'"
                             :text="'A termék árát a készlet erejéig tudjuk tartani. Nagyobb mennyiség esetén keresd kollégáinkat!'"/>
                @endif

                <input class="border border-sky-500 px-2 rounded-l-md w-16 qty in_cart" type="text"
                       value="{{ (app('Cart')->inCart($product) ? app('Cart')->getQty($product) : 1) }}"
                       @if($product->getStockLimit() !== null) data-max="{{ $product->getStockLimit() }}" @endif />
                <div class="mr-4">
                    <button class="qty-inc rounded-tr-md block border-sky-500 border-r border-t px-2 h-4"><i
                            class="fal fa-caret-up"></i></button>
                    <button class="qty-dec rounded-br-md block border-sky-500 border-b border-r px-2"><i
                            class="fal fa-caret-down "></i></button>
                </div>


                <button type="submit"
                        class="cart-button border border-solid border-sky-500 px-4 py-1 rounded-md text-riel-light hover:bg-riel-light hover:text-white"
                        data-url="{{ route('cart.set', ['Termek_ID' => $product->Termek_ID, 'locale' => app('Lang')->getLocale()]) }}"
                        data-label="@lang('form.save')"
                        data-alt-label="@lang('form.processing')"
                        data-alt2-label="@lang('form.saved')"
                >
                    <i class="fal fa-shopping-bag mr-1 "></i>
                    @lang('form.save')
                </button>

                <button
                    data-url="{{ route('cart.delete', ['Termek_ID' => $product->Termek_ID, 'locale' => app('Lang')->getLocale()]) }}"
                    class="text-red-600 hover:text-red-700 ml-4 text-2lg hover:text-gray-700 cart-delete-button">
                    <i class="fal fa-trash-alt "></i>
                </button>

            </div>

            <div class="mt-2 lg:hidden flex gap-6">

                <div class="">
                    @include('pages.cart.includes.item-price')
                </div>


                <div>
                    @include('pages.cart.includes.item-total-price')
                </div>


            </div>
        </div>
    </div>

    <div class="lg:basis-1/6 px-4 self-center hidden lg:block">
        @include('pages.cart.includes.item-total-price')
    </div>
</div>
