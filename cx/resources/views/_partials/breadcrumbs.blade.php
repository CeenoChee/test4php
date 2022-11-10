@unless ($breadcrumbs->isEmpty())
    <nav class="xl:mt-0 my-auto pt-2 md:pt-4" id="breadcrumb">
        <ol class="rounded text-xs text-gray-800">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li class="inline-block">
                        <a href="{{ $breadcrumb->url }}"
                           class="text-riel-light hover:text-sky-700 focus:text-sky-700">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li class="inline-block">
                        <span class="text-neutral-500">{{ $breadcrumb->title }}</span>
                    </li>
                @endif

                @unless($loop->last)
                    <li class="text-neutral-300 px-2 inline-block">
                        <i class="fal fa-angle-right"></i>
                    </li>
                @endif

            @endforeach
        </ol>
    </nav>

@endunless
