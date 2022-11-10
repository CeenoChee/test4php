@php
    $min = null;
    $max = null;
    $request = request();

    if($request->has($name)) {
        $minMax = explode('-', $request->get($name));
        if(count($minMax) == 2) {
            $min = $minMax[0];
            $max = $minMax[1];
        }
    }

    if(($min === null || $max === null) && count($values) > 0) {
        $keys = array_keys($values);
        $min = $keys[0];
        $max = $keys[count($keys) - 1];
    }
@endphp

@include('pages.product-categories.includes.filters.range-filter', [
    'name' => $name,
    'values' => $values,
    'min' => $min,
    'max' => $max,
    'valueType' => ''
])
