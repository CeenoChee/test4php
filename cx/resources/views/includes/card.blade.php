<div class="hidden shadow-md p-8 text-center min-h-300 rounded-md bg-white home-card">
    @if ($card->trans->media->first())
        <img class=" mx-auto mb-3 h-[55px] rounded-md" src="{{ $card->trans->media->first()->getFilesUrl() }}">
    @endif

    <h2 class="text-2lg font-thin mb-3 text-riel-dark">
        {{ $card->trans->name }}
    </h2>
    <div class="mb-3 min-h-85">
        {{ $card->trans->description }}
    </div>

    <div class="relative h-10">
        <a class="btn max-w-10 mx-auto"
           href="{{ $card->trans->link }}">@lang('pages/home.more')</a>
    </div>
</div>
