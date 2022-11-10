@if($manufacturer->trans)
    <a href="{{ $manufacturer->trans->link }}">
        @if ($manufacturer->media->first())
            <img data-src="{{ $manufacturer->media->first()->getFilesUrl() }}" src="{{ asset('assets/images/placeholders/240x80.png') }}" class="h-[81px] hover:grayscale lazyload rounded-md">
        @endif
    </a>
@endif
