@if ($errors->has($name))
    <span class="help-block">{{ $errors->first($name) }}</span>
@endif