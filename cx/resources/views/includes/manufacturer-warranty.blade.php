<div class="acc-item">
    <input type="checkbox" id="item{{ $manufacturer->Gyarto_ID }}" name="item" class="item"/>
    <label for="item{{ $manufacturer->Gyarto_ID }}" class="accordionitem">
        <h3>
            @if ($manufacturer->media->first())
                <img class="logo" src="{{ $manufacturer->media->first()->getFilesUrl() }}">
            @endif
        </h3>
    </label>
    <div class="hiddentext">
        {!! $manufacturer->trans->warranty_content !!}
    </div>
</div>
