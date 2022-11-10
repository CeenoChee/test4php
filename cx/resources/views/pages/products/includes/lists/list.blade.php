<div class="mt-4 prods">
    @foreach($products as $product)
        @include('pages.products.includes.lists.item', [
            'product' => $product,
            'extraProperties' => isset($extraProperties) ? $extraProperties : []
        ])
    @endforeach
</div>
