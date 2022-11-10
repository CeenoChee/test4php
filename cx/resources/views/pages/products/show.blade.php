@extends('layouts.app')

@section('title')
    {{ $product->manufacturer->Nev }} - {{ $product->Kod }} - {{ $product->trans->Nev }}
@endsection

@section('content_title')
    {{ $product->manufacturer->Nev }} - {{ $product->Kod }}
@endsection

@section('meta_description')
    @foreach($product->getProductAttributes()->get() as $attribute) {{ $attribute->getName() }}: {{ $attribute->getValue() }}, @endforeach
@endsection

@section('structured_data')
    {
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "{{ addslashes($product->trans->Nev) }}",
    @if($product->images->count()) "image": "{{ $product->images->first()->getUrl('product-middle') }}", @endif
    "description": "@foreach($product->getProductAttributes()->get() as $attribute) {{ $attribute->getName() }}: {{ $attribute->getValue() }}, @endforeach
    ",
    "sku": "{{ $product->Kod }}",
    "mpn": "{{ $product->Kod }}",
    "brand": {
    "@type": "Brand",
    "name": "{{ $product->manufacturer->Nev }}"
    }
    }
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('product', $product) }}
@endsection

@section('content')

    <x-card id="product" class="border border-solid border-neutral-200">
        <div class="prod-item md:flex mb-8 p-0 lg:p-4"
             data-prod-id="{{ $product->Termek_ID }}"
             data-prod-code="{{ $product->Kod }}">

            <div class="md:basis-2/3 md:flex lg:border-r border-neutral-200">
                <div class="prod-image justify-center flex">

                    @if(!empty(json_decode($images)))
                        <the-lightbox :images="{{$images}}" :thumbnails="{{$thumbnails}}"/>
                    @else
                        <div
                            class="w-[80px] h-[80px] md:w-[140px] md:h-[140px] bg-no-repeat bg-center bg-contain mx-auto md:mx-0"
                            style="background-image: url('{{ asset('assets/images/product/no_image.png') }}');"
                            title="{{ $product->trans->Nev }}"></div>
                    @endif

                </div>

                <div class="px-4 w-full">
                    <div class="uppercase text-xs font-thin">{{ $product->manufacturer->Nev }}</div>

                    <div class="flex">

                        <div class="text-lg font-semibold grow">
                            {{ $product->Kod }}
                        </div>

                        <div class="relative hidden lg:block">
                            @include('pages.comparison.includes.button', ['product' => $product])
                        </div>

                    </div>

                    <div>
                        <div class="mb-2 xl:pr-32">{{ $product->trans->Nev }}</div>

                        <div class="relative lg:hidden">
                            @include('pages.comparison.includes.button', ['product' => $product])
                        </div>


                        @include('pages.products.includes.tag', [
                            'product' => $product
                        ])
                        <div class="text-gray-500 font-thin text-xs ">
                            <div>
                                @if($product->Garancia)
                                    @lang('pages/warranties.warranty'): {{ Fct::warranty($product->Garancia) }}
                                @endif
                            </div>
                            @foreach($product->getProductAttributes()->limit(3)->get() as $productAttribute)
                                <div>
                                    {{ $productAttribute->getName() }}: {{ $productAttribute->getValue() }}
                                </div>
                            @endforeach
                        </div>

                        @if($product->trans)
                            <div class="text-gray-500 font-thin">{!! $product->trans->Leiras !!}</div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="prod-data basis-1/3 pl-4 mt-4 lg:mt-0">
                @include('pages.products.includes.info-box', [
                    'product' => $product,
                    'show' => true
                ])
            </div>
        </div>

    </x-card>



    <div class="lg:flex gap-4">
        <div class="lg:basis-3/4">
            @if($relatedProducts->count())
                <h2 class="uppercase text-gray-500 font-semibold my-4 text-center md:text-left">@lang('pages/products.related_products')</h2>
                @include('pages.products.includes.lists.compact', [
                    'products' => $relatedProducts
                ])
            @endif

            @if($additionalProducts->count())
                <h2 class="uppercase text-gray-500 font-semibold my-4 text-center md:text-left">@lang('pages/products.additional_products')</h2>

                @include('pages.products.includes.lists.compact', [
                    'products' => $additionalProducts
                ])
            @endif

            @if($replacementProducts->count())
                <h2 class="uppercase text-gray-500 font-semibold my-4 text-center md:text-left">@lang('pages/products.substitute_products')</h2>

                @include('pages.products.includes.lists.compact', [
                    'products' => $replacementProducts
                ])
            @endif
        </div>

        <div class="lg:basis-1/4 basis-full">
            @if($product->getDownloadableMedia()->count())
                @include('pages.products.includes.datasheets', ['product' => $product])
            @endif

            @if(!empty($product->getProductAttributes()->get()))
                @include('pages.products.includes.properties', ['product' => $product])
            @endif
        </div>
    </div>


@endsection


@push('scripts')
    <script src="{{ mix('js/lightbox.js') }}"></script>
@endpush

@section('bottom')
    {!! app('Comparison')->renderBox() !!}
@endsection
