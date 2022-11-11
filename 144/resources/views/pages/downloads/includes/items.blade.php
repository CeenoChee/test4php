<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">
    @foreach($downloads as $download)
        @if($download->trans())
            <x-card class="flex flex-col">
                <div class="grow">
                    <div class="mb-2">
                        <img class="mx-auto"
                             src="{{ route('file.download.image', ['thumbnail', $download->getIcon()->file_name]) }}">
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

                <a class="btn w-fit mx-auto font-bold" href="{{ route('media.get', $download->getDownload()->file_name) }}">
                    <i class="fa fa-download"></i> @lang('pages/downloads.download')
                </a>

            </x-card>
        @endif
    @endforeach
</div>
