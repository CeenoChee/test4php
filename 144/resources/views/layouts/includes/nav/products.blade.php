<div class="group inline-block">
    <li class="inline-block uppercase p-4 outline-none  flex items-center min-w-32">

        <span class="pr-1 font-bold flex-1 hover:text-sky-300">
             <a href="{{ LUrl::route('product.category.main')}}"
                class="hover:text-sky-300 text-white">@lang('pages/products.products')</a>
        </span>
        <span>
                    @include('layouts.includes.nav.svg.arrow-y-svg')
                    </span>
    </li>

    <ul class="product-menu z-30 bg-riel-dark rounded-bl-md transform scale-0 group-hover:scale-100 w-60
                absolute origin-top min-h-[380px] py-4 pl-4">

        @php $category = app('Category'); @endphp
        @foreach($parentCategories as $parentCategory)
            <li class="rounded-l-full hover:bg-riel-light pr-4">
                <a @if($parentCategory->trans) href="{{ LUrl::route('product.category.show',$parentCategory->trans->Eleres) }}"
                   @endif
                   class="w-full text-left flex items-center outline-none focus:outline-none hover:text-white px-3 parent py-2 text-white">
                                <span class="pr-1 flex-1 flex">
                                        <i class="fal mr-2 {{$parentCategory->getIcon()}} w-4 text-center !leading-[inherit]"></i>
                                        @if($parentCategory->trans)
                                        <span>{{ $parentCategory->trans->Nev }}</span>
                                    @else
                                        <span>{{ $parentCategory->Nev }}</span>
                                    @endif
                                    </span>

                    <span class="mr-auto">
                                        @include('layouts.includes.nav.svg.arrow-x-svg')
                                    </span>
                </a>

                @if(!$category->isEmpty($parentCategory->TermekfaLevel_ID))

                    <ul class="product-sub p-4 text-left bg-riel-light rounded-br-md absolute top-0 right-0 @if($parentCategory->children->count() > 12) divide-x divide-gray-300 grid grid-cols-2 w-[600px] @else w-80 @endif">


                        @foreach($parentCategory->children as $childCategory)

                            @if($loop->first || $loop->index == 12)
                                <div @if($loop->index == 12) class="pl-4" @endif>
                            @endif

                            @include('layouts.includes.nav.product-sub-category')

                            @if($loop->index == 11 || $loop->last)
                              </div>
                            @endif

                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
        <li class="px-4 text-left mt-4 promotion-menu">
            <a href="{{ LUrl::route('page.promotion') }}"
               class="py-1 px-2 rounded-md hover:bg-red-600 hover:text-white bg-red-700 text-white">
                <i class="fa mr-1 fa-percent"></i>
                @lang('pages/sales.sales')
            </a>
        </li>
    </ul>
</div>

@push('scripts')
    <script>
        $('.product-sub').height($('.product-menu').height());
    </script>
@endpush
