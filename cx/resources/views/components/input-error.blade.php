@if ($errors->has($field))
    <div {{ $attributes->merge(['class' => 'text-red-600 font-bold relative bottom-[10px]']) }}>
         {{ $errors->first($field) }}
    </div>
@endif
