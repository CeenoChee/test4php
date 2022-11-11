@if(count($values))
    @php
        $min = null;
        $max = null;
        $request = request();

        if($request->has($name)) {
            $minMax = explode('-', $request->get($name));
            if(count($minMax) == 2) {
                $min = $valueType === 'int' ? $minMax[0] : (float)$minMax[0];
                $max = $valueType === 'int' ? $minMax[1] : (float)$minMax[1];
            }
        }

        if((is_null($min) || is_null($max)) && count($values) > 0) {
            $keys = array_keys($values);
            $min = $keys[0];
            $max = $keys[count($keys) - 1];
        }
    @endphp


    <div class="range-filter">
        <div class="rangeInfo text-sm"></div>
        <input type="hidden" id="{{ $name }}"/>
        <div class="minmax">
            <div>
                <div class="label">Min</div>
                <select class="form-control select-min">
                    @foreach($values as $value => $label)
                        <option value="{{ $value }}"
                                @if($min == $value) selected="selected" @endif>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <div class="label">Max</div>
                <select class="form-control select-max">
                    @foreach($values as $value => $label)
                        <option value="{{ $value }}"
                                @if($max == $value) selected="selected" @endif>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endif
