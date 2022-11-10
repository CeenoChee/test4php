<h2 class="uppercase text-gray-500 font-semibold my-4 text-center md:text-left"><i
        class="fal fa-download"></i> @lang('pages/downloads.downloads')</h2>

<div class="bg-white py-2 px-6 shadow-2xl rounded-md">
    <table class="docprop">
        @foreach($product->getDownloadableCollections() as $collection)
            @foreach($product->getDownloadableMedia()->where('media.collection_name', $collection)->orderBy('sort')->get() as $download)
                <tr>
                    <td class="font-semibold pr-4">@lang('media.'.$download->collection_name):</td>
                    <td>
                        <a href="{{ route('media.get', $download->file_name) }}" class="text-truncate text-riel-light"
                           target="_blank" title="{{ $download->name }}">{{ $download->name }}.{{$download->getExtension()}}</a>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </table>
</div>
