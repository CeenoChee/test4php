@php
    $sort = request('rendezes');
    $sortDirection = request('rendezes-irany', 'novekvo');
    $results = (int)request('talalatok-szama', 25);
    if($results < 1) {
        $results = 1;
    }
    $total = $products->total();
    $to = $products->currentPage() * $results;
    if($to > $total) {
        $to = $total;
    }
@endphp

<div class="lg:hidden product-list-actions border-neutral-200 border p-2 rounded-md mt-4">

    <div class="total-block flex">
        <div class="total-label px-2 border-neutral-200 border-r">
            {{ ($products->currentPage() - 1) * $results + 1 }}-{{ $to }}
            / {{ $total }}
        </div>
        <select class="form-control talalatok-szama px-2 bg-white border-neutral-200 border-r">
            <option value="25" @if($results == 25) selected="selected" @endif>25</option>
            <option value="50" @if($results == 50) selected="selected" @endif>50</option>
            <option value="100" @if($results == 100) selected="selected" @endif>100</option>
            <option value="200" @if($results == 200) selected="selected" @endif>200</option>
        </select>
        <div class="orderby-block border-neutral-200 flex">
            <select class="form-control rendezes bg-white border-neutral-200 border-l px-2 ">
                <option value="cikkszam"
                        @if(empty($sort) || $sort == 'cikkszam') selected="selected" @endif>@lang('pages/products.model_no')</option>
                <option value="nev"
                        @if($sort == 'nev') selected="selected" @endif>@lang('form.name')</option>
                @if(Fct::isRielActive())
                    <option value="ar"
                            @if($sort == 'ar') selected="selected" @endif>@lang('prices.price')</option>
                @endif
            </select>
            <button class="sort-order border-neutral-200 border-l px-2 "
                    data-value="{{ $sortDirection == 'novekvo' ? 'novekvo' : 'csokkeno' }}">
                <i class="fal fa-sort-amount-down-alt" title="@lang('global.asc')"></i>
                <i class="fal fa-sort-amount-down" title="@lang('global.desc')"></i>
            </button>
        </div>
    </div>

        <div class="pagination-block grow mt-4">
            {!! $pagerLinks !!}
        </div>

</div>


<div class="hidden lg:flex product-list-actions  border-neutral-200 border p-2 rounded-md">

    <div class="total-block flex">
        <div class="total-label px-2 border-neutral-200 border-r">
            {{ ($products->currentPage() - 1) * $results + 1 }}-{{ $to }}
            / {{ $total }}
        </div>
        <select class="form-control talalatok-szama px-2 bg-white border-neutral-200 border-r">
            <option value="25" @if($results == 25) selected="selected" @endif>25</option>
            <option value="50" @if($results == 50) selected="selected" @endif>50</option>
            <option value="100" @if($results == 100) selected="selected" @endif>100</option>
            <option value="200" @if($results == 200) selected="selected" @endif>200</option>
        </select>
    </div>
    <div class="pagination-block grow">
        {!! $pagerLinks !!}
    </div>
    <div class="orderby-block border-neutral-200 flex">
        <select class="form-control rendezes bg-white border-neutral-200 border-l px-2 ">
            <option value="cikkszam"
                    @if(empty($sort) || $sort == 'cikkszam') selected="selected" @endif>@lang('pages/products.model_no')</option>
            <option value="nev"
                    @if($sort == 'nev') selected="selected" @endif>@lang('form.name')</option>
            @if(Fct::isRielActive())
                <option value="ar"
                        @if($sort == 'ar') selected="selected" @endif>@lang('prices.price')</option>
            @endif
        </select>
        <button class="sort-order border-neutral-200 border-l px-2 "
                data-value="{{ $sortDirection == 'novekvo' ? 'novekvo' : 'csokkeno' }}">
            <i class="fal fa-sort-amount-down-alt" title="@lang('global.asc')"></i>
            <i class="fal fa-sort-amount-down" title="@lang('global.desc')"></i>
        </button>
    </div>
</div>
