@if(!$category->isEmpty($childCategory->TermekfaLevel_ID) && $childCategory->trans)
    <li class="h-fit">
        <a href="{{ LUrl::routeCategory($childCategory) }}"
           class="rounded-md block py-1 text-gray-200 hover:text-white font-normal">
            @if($childCategory->trans)
                {{ $childCategory->trans->Nev }}
            @else
                {{ $childCategory->Nev }}
            @endif
        </a>
    </li>
@endif
