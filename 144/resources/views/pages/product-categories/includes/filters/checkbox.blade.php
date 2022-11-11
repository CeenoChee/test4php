@php
$request = request();
if (is_bool($value)) {
    $value = ($value ? 'true' : 'false');
    $checked = $request->has($name);
} else {
    // $value = (int) $value;
    $values = $request->has($name) ? explode('-', $request->get($name)) : [];

    if (! isset($checked)) {
        foreach ($values as $i => $val) {
            $values[$i] = (int) $val;
        }
        $checked = in_array($value, $values);
    }
}
@endphp

<div class="checkbox">
    <label for="{{ $name }}-{{ $value }}" class="text-sm">
        {{ $label }}
        @if($checked)
            <input type="checkbox" id="{{ $name }}-{{ $value }}" checked="checked" class="search-checkbox"
                   data-name="{{ $name }}" data-value="{{ $value }}" data-label="{{ $label }}">
        @else
            <input type="checkbox" id="{{ $name }}-{{ $value }}" class="search-checkbox" data-name="{{ $name }}"
                   data-value="{{ $value }}" data-label="{{ $label }}">
        @endif
        @isset($count)
            <span class="text-gray-400">({{ $count }})</span>
        @endisset
        <span class="checkmark{{ (isset($type) ? ' ' . $type : '') }}"></span>
    </label>
</div>
