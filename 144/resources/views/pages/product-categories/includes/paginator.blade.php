@php
    $links = [];
    foreach ($elements as $element) {
        if(is_array($element)) {
            foreach ($element as $page => $url) {
                $links[$page] = $url;
            }
        }
    }
@endphp
@if(count($links) > 1)
    <ul class="pagination flex justify-center font-thin" id="product-category-list-pagination">
        @if (!$paginator->onFirstPage())
            <li class="mr-6 ">
                <a class="px-2" href="{{ LUrl::routeCategory($productCategory, array_merge($params, ['page' => 1])) }}"
                   rel="prev" data-page="1"><i class="fal fa-chevron-double-left text-2xs text-gray-500 hover:text-riel-light"></i></a>
            </li>
            <li class="mr-6">
                <a class="px-2" href="{{ LUrl::routeCategory($productCategory, array_merge($params, ['page' => $paginator->currentPage() - 1])) }}"
                   rel="prev" data-page="{{ $paginator->currentPage() - 1 }}"><i class="fal fa-chevron-left text-2xs text-gray-500 hover:text-riel-light"></i></a>
            </li>
        @endif

        @for ($page = ($paginator->currentPage() - 2); $page <= ($paginator->currentPage() + 2); $page++)
            @if(isset($links[$page]))
                @if ($page == $paginator->currentPage())
                    <li class="active bg-riel-light text-white px-2 rounded-md"><span>{{ $page }}</span></li>
                @else
                    <li>
                        <a class="px-2" href="{{ LUrl::routeCategory($productCategory, array_merge($params, ['page' => $page])) }}"
                           data-page="{{ $page }}">{{ $page }}</a>
                    </li>
                @endif
            @endif
        @endfor

        @if ($paginator->hasMorePages())
            <li class="ml-6">
                <a class="px-2" href="{{ LUrl::routeCategory($productCategory, array_merge($params, ['page' => $paginator->currentPage() + 1])) }}"
                   rel="next" data-page="{{ $paginator->currentPage() + 1 }}"><i class="fal fa-chevron-right text-2xs text-gray-500 hover:text-riel-light"></i></a>
            </li>
            <li class="ml-6">
                <a class="px-2" href="{{ LUrl::routeCategory($productCategory, array_merge($params, ['page' => $paginator->lastPage()])) }}"
                   rel="next" data-page="{{ $paginator->lastPage()}}"><i class="fal fa-chevron-double-right text-2xs text-gray-500 hover:text-riel-light"></i></a>
            </li>
        @endif
    </ul>
@endif

