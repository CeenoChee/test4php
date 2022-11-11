<div class="filter-box first active"
    data-category-id="elerhetoseg"
    data-category-name="@lang('pages/products.availability')"
    data-type="Felsorolt">
    <button class="filter-button text-black hover:text-riel-light">
        @lang('pages/products.availability')
    </button>
    <div class="filter-subnav">
        @include('pages.product-categories.includes.filters.checkbox', ['name' => 'projekt', 'label' => trans('pages/products.project'), 'value' => true])
        @include('pages.product-categories.includes.filters.checkbox', ['name' => 'ujdonsag', 'label' => trans('pages/products.news'), 'value' => true])
        @if(Fct::isRielActive())
            @include('pages.product-categories.includes.filters.checkbox', ['name' => 'akcios', 'label' => trans('pages/products.sale'), 'value' => true])
            @php
                $onSale = request()->get('akcios');
            @endphp
            @if($onSale && $onSale !== 'true')
                <input type="hidden" id="on-sale" value="{{ $onSale }}">
            @endif
            @include('pages.product-categories.includes.filters.checkbox', ['name' => 'keszleten', 'label' => trans('pages/products.on_stock'), 'value' => true])
            @include('pages.product-categories.includes.filters.checkbox', ['name' => 'kifuto', 'label' => trans('pages/products.discontinued'), 'value' => true])
        @endif
    </div>
</div>

@if($manufacturers->count())
    <div class="filter-box @if(request()->has('gyarto')) active @endif" data-category-id="gyarto"
        data-category-name="@lang('pages/products.manufacture')" data-type="Felsorolt">
        <button class="filter-button text-black hover:text-riel-light">
            <div>@lang('pages/products.manufacture')</div>
        </button>
        <div class="filter-subnav">
            @foreach($manufacturers as $manufacturer)
                @include('pages.product-categories.includes.filters.checkbox', [
                    'name' => 'gyarto',
                    'value' => $manufacturer->Gyarto_ID,
                    'count' => $manufacturer->count,
                    'label' => $manufacturer->Nev,
                    'type' => 'circle'
                ])
            @endforeach
        </div>
    </div>
@endif

@if(count($rangePrices) && Fct::isRielActive())
    <div class="filter-box @if(request()->has('ar')) active @endif" data-category-id="ar"
        data-category-name="@lang('prices.price')" data-type="Intervallum">
        <button class="filter-button text-black hover:text-riel-light">
            <div>@lang('prices.price')</div>
        </button>
        <div class="filter-subnav">
            @include('pages.product-categories.includes.filters.item-range-filter', [
                'name' => 'ar',
                'values' => $rangePrices,
            ])
        </div>
    </div>
@endif

@if($productCategory !== null)
    @foreach($attributes as $attribute)
        <div class="filter-box @if(request()->has($attribute->BelsoNev)) active @endif"
            data-category-id="{{ $attribute->BelsoNev }}" data-category-name="{{ $attribute->Cimke }}"
            data-type="{{ $attribute->Tipus }}">
            <button class="filter-button text-black hover:text-riel-light">
                <div>{{ $attribute }}</div>
            </button>
            <div class="filter-subnav">
                @if(($attribute->Tipus == 'Intervallum' || $attribute->Tipus == 'val') && count($attribute->values) > 1)
                    @if($attribute->Tipus == 'Intervallum')
                        @php
                            $valueType = 'int';
                        @endphp
                    @elseif($attribute->Tipus == 'val')
                        @php
                            $valueType = 'float';
                        @endphp
                    @endif
                    @include('pages.product-categories.includes.filters.range-filter', [
                        'name' => $attribute->BelsoNev,
                        'values' => $attribute->values,
                        'valueType' => $valueType
                    ])
                    <div class="top-filter"></div>
                @elseif($attribute->Tipus == 'Felsorolt')
                    @foreach($attribute->values as $id => $value)
                        @include('pages.product-categories.includes.filters.checkbox', [
                            'name' => $attribute->BelsoNev,
                            'value' => $id,
                            'label' => $value['name'],
                            'count' => $value['count'],
                            'checked' => $value['checked'],
                            'type' => 'circle'
                        ])
                    @endforeach
                @elseif($attribute->Tipus == 'Logikai')
                    @include('pages.product-categories.includes.filters.checkbox', [
                        'name' => $attribute->BelsoNev,
                        'label' => (string)$attribute,
                        'value' => true,
                        'type' => 'circle'
                    ])
                @endif
            </div>
        </div>
    @endforeach
@endif
