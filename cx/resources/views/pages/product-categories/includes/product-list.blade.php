@php
    $pagerLinks = $products->onEachSide(2)->links('pages.product-categories.includes.paginator', ['productCategory' => $productCategory, 'params' => $params]);
@endphp

@if($productCategory)
    <div class="md:flex">
        <h2 class="font-thin leading-none md:py-4 text-3lg grow">{{ $productCategory->trans->Nev }}</h2>
        {!! $breadcrumbs !!}
    </div>
@endif


@if($products->total() > 0)
    <div class="mb-4 shadow-2xl rounded-md bg-white">
        @include('pages.products.includes.lists.actions', [
            'products' => $products,
            'pagerLinks' => $pagerLinks
        ])
    </div>

        @include('pages.products.includes.lists.list', [
            'products' => $products,
            'extraProperties' => $extraProperties
        ])

    <div class="mb-4 shadow-2xl rounded-md bg-white">
        @include('pages.products.includes.lists.actions', [
            'products' => $products,
            'pagerLinks' => $pagerLinks
        ])
    </div>

@else
    <div class="mb-4 shadow-2xl rounded-md bg-white">
        @include('pages.products.includes.lists.actions', [
            'products' => $products,
            'pagerLinks' => $pagerLinks
        ])
    </div>
    <x-card>
        @include('layouts.includes.message', [
            'class' => 'alert-warning',
            'message' => 'Nincs találat.'
        ])
    </x-card>
@endif

<div class="hidden xl:fixed hover:cursor-pointer text-white py-2 px-4 rounded-md w-fit top-[100px] text-xs font-bold @if($products->total() == 0) bg-orange-300 @else bg-riel-light @endif" id="prod-jump-top"
     onclick="goToTop()"
>
    <i class="fa fa-hand-back-point-up"></i> @lang('pages/products.results', ['count' => $products->total()])
</div>

