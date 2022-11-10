@if(!$isRoot)
    <a href="{{ LUrl::routeCategory($parentProductCategory) }}" id="cat-nav-back" class="float-right relative bottom-[45px]">
        <i class="fa fa-arrow-left-long"></i>
    </a>
@endif
<div class="cat">
    <ul>

        @foreach($childCategories as $childCategory)
            <li class="py-1">
                <a href="{{ LUrl::routeCategory($childCategory) }}"
                   @if($childCategory->TermekfaLevel_ID == $activeProductCategoryID) class="font-semibold text-riel-light" @else class="text-inherit" @endif >

                    @if($isRoot)
                        <i class="fal mr-1 w-6 text-lg text-center text-riel-dark {{$childCategory->getIcon()}} "></i>
                    @endif

                    @if($childCategory->trans)
                        {{ $childCategory->trans->Nev }}
                    @else
                        {{ $childCategory->Nev }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>
