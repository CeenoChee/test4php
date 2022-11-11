
    <div class="cart cart-form relative flex justify-center sm:justify-start @if($product->KeszletErejeig) while-stocks-last @endif">
        @if($product->KeszletErejeig)
            <x-popup :title="'Készlet erejéig'"
                     :text="'A termék árát a készlet erejéig tudjuk tartani. Nagyobb mennyiség esetén keresd kollégáinkat!'"/>
        @endif
        {{-- @if($product->unit){{  $product->unit->Nev }}@endif --}}
        <input
            class="w-12 rounded-l-md border border-neutral-400 px-2 qty @if(app('Cart')->inCart($product)) in_cart @endif"
            type="text"
            value="{{ (app('Cart')->inCart($product) ? app('Cart')->getQty($product) : 1) }}"
            @if($product->getStockLimit() !== null) data-max="{{ $product->getStockLimit() }}" @endif />
        <div class="2xl:mr-4 mr-2">
            <button class="qty-inc rounded-tr-md block border-neutral-400 border-r border-t px-2 h-4"><i
                    class="fal fa-caret-up"></i></button>
            <button class="qty-dec rounded-br-md block border-neutral-400 border-b border-r px-2 h-4 leading-none"><i
                    class="fal fa-caret-down relative bottom-[3px]"></i></button>
        </div>

            <button
                class="text-center rounded-md text-white py-1 px-4 text-sm cart-button bg-green-600 hover:bg-green-500"
                data-url="{{ route('cart.set', ['Termek_ID' => $product->Termek_ID, 'locale' => app('Lang')->getLocale()]) }}"
                data-label="<i class='fal fa-shopping-bag'></i> @lang('pages/products.add_to_cart')"
                data-alt-label="@lang('pages/products.processing')"
                data-alt2-label="@lang('pages/products.added')"
                data-save-label="<i class='fal fa-arrows-rotate'></i> @lang('pages/orders.update')">
                @if(app('Cart')->inCart($product))
                    <i class="fal fa-arrows-rotate "></i> @lang('pages/orders.update')
                @else
                    <i class="fal fa-shopping-bag "></i> @lang('pages/products.add_to_cart')
                @endif
            </button>


            <button
                data-url="{{ route('cart.delete', ['Termek_ID' => $product->Termek_ID, 'locale' => app('Lang')->getLocale()]) }}"
                class="text-red-400 hover:text-red-700 ml-4 text-2lg delete-button @if(isset($cart) && (!$cart->inCart($product) || $product->getStockLimit() === 0)) hidden @endif">
                <i class="fal fa-trash-alt"></i>
            </button>

    </div>

