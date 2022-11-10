<ul class="flex" id="compare-box-content">
    @foreach($products as $product)
        <li data-prod-id="{{ $product->Termek_ID }}" data-label="{{ $product->Kod }}" class="bg-white p-2 border border-neutral-200 inline-block min-w-[200px]">
            <div class="text-right">
                <button class="close" data-url="{{ route('comparison.delete', ['Termek_ID' => $product->Termek_ID, 'locale' => app('Lang')->getLocale()]) }}">
                    <i class="fas fa-times-circle text-red-400 hover:text-red-500"></i>
                </button>
            </div>

            <a href="{{ LUrl::routeProduct($product) }}" class="text-inherit flex flex-col">

                <div class="h-[120px]">
                    @include('pages.products.includes.main-image', [
                  'product' => $product,
                  'size' => 'product-small',
              ])
                </div>



                <div class="content-end">
                    <div class="text-2xs text-gray-400 uppercase">
                        {{$product->manufacturer->Nev}}
                    </div>
                    {{$product->Kod}}
                </div>
            </a>


        </li>
    @endforeach
</ul>


