@if(false && in_array(config('riel.stage'), ['release', 'dev']))
    <div class="dev-header bg-orange-500 relative top-[50px] text-center font-semibold text-xs py-1">
        [{{ strtoupper(config('riel.stage')) }}] - [{{ strtoupper(config('riel.stage')) }}] - [{{ strtoupper(config('riel.stage')) }}]
    </div>
@endif
