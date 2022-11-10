<div class="popup-wrapper">
    <div class="popup">
        @if(isset($title))
            <div class="title">
                {{ $title }}
            </div>
        @endif

        {{ $text }}
    </div>
</div>
