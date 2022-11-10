<div class="left">
    <div class="title">
        <h2>@lang('pages/products.products')</h2>
        <a href="{{ LUrl::routeCategory() }}">@lang('global.all')</a>
    </div>
    <div class="cat">
        @foreach($parentCategories as $parentCategory)
            <div><a href="{{ LUrl::routeCategory($parentCategory) }}"
                    data-category-id="{{ $parentCategory->TermekfaLevel_ID }}">@if($parentCategory->trans){{ $parentCategory->trans->Nev }}@else{{ $parentCategory->Nev }}@endif</a>
            </div>
        @endforeach
        <div>
            <a href="{{LUrl::route('page.promotion')}}" class="nochild special">@lang('pages/products.sale_title')</a>
        </div>
    </div>
</div>
<div class="right">
    <div class="title">
        <h2></h2>
        <a href="{{ LUrl::routeCategory() }}">@lang('global.all')</a>
    </div>
    @php $category = app('Category'); @endphp
    @foreach($parentCategories as $parentCategory)
        @if(!$category->isEmpty($parentCategory->TermekfaLevel_ID))
            <div class="cat" data-category-id="{{ $parentCategory->TermekfaLevel_ID }}">
                @foreach($parentCategory->children as $childCategory)
                    @if(!$category->isEmpty($childCategory->TermekfaLevel_ID) && $childCategory->trans)
                        <div>
                            <a href="{{ LUrl::routeCategory($childCategory) }}">@if($childCategory->trans){{ $childCategory->trans->Nev }}@else{{ $childCategory->Nev }}@endif</a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    @endforeach
</div>
