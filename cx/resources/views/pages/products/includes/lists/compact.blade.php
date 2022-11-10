<div class="prods small grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-4">
    @foreach($products as $product)
        @include('pages.products.includes.lists.compact-item', [
            'product' => $product,
            'extraProperties' => isset($extraProperties) ? $extraProperties : []
        ])
    @endforeach
</div>
