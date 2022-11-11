<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach($downloads as $download)
        <x-card class="flex flex-col">
            <div class="grow">
                <div class="mb-2">
                    <img class="mx-auto"
                         src="{{ route('file.download.image', ['thumbnail', $download->getIcon()->file_name]) }}">
                </div>

                <div class="text-2xs uppercase text-gray-400 text-center">
                    @foreach($download->categories as $category)
                        {{ $category->translation->name }}
                        @if(!$loop->last),@endif
                    @endforeach
                </div>

                <h3 class="font-semibold text-center">
                    {{ $download->trans()->name }} {{ $download->version }}
                </h3>

                <div class="text-xs text-gray-400 mb-4 text-center">
                    {{ Fct::formatBytes($download->getDownload()->size) }}
                </div>

                <div class="text-gray-400 mb-10">
                    {{ $download->trans()->description }}
                </div>
            </div>

            <a class="btn mx-auto font-bold"
               href="{{ route('media.get', $download->getDownload()->file_name) }}">
                <i class="fa fa-download"></i> @lang('pages/downloads.download')
            </a>

        </x-card>
    @endforeach
</div>
