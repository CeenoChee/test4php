@foreach($permissions as $permission)
    @if($permission->code == 'SERV')
        @if($permission->value)
            {!! Form::hidden('permission_' . $permission->code, 'true') !!}
        @endif
    @else
        <div class="permission @if(!$loop->last) mb-1 @endif">

            <label class="switch mr-1">

                {!! Form::checkbox('permission_' . $permission->code, 'true', $permission->value, ['class' => 'permission-input', ($permission->code == 'FF' || $permission->code == 'ADMIN' && isset($isMySettings) && $isMySettings) ? 'disabled' : '']) !!}
                <span class="switch-slider"></span>
            </label>
            @if(!empty($permission->icon))
                <i class="fa-solid w-6 text-center text-lg transition duration-300 {{$permission->icon}} @if($permission->value) text-riel-light @else text-gray-200 @endif"></i>
            @endif
            <span>{{ $permission->name }}</span>
        </div>
    @endif
@endforeach

@if(isset($isMySettings) && !$isMySettings)
    <div>
        <label class="switch mr-1">
            {!! Form::checkbox('permission_active', 'true', $active) !!}
            <span class="switch-slider"></span>
        </label>
        <span> @lang('pages/account.active')</span>
    </div>
@else
    {!! Form::hidden('permission_active', 'true') !!}
@endif

@push('scripts')
    <script>
        $(document).ready(function () {
            $('input[name="permission_PENZ"]').click(function () {
                let input = $('input[name="permission_FF"]');

                input.prop('checked', $(this).is(':checked'));

                if (input.is(':checked')) {
                    $('.permission').find('.fa-triangle-exclamation').addClass('text-riel-light');
                } else {
                    $('.permission').find('.fa-triangle-exclamation').removeClass('text-riel-light');
                }
            })

            $('.switch-slider').click(function () {

                let slider = $(this);

                setTimeout(function () {
                    if (slider.siblings('input').is(':checked')) {
                        slider.closest('.permission').find('i').addClass('text-riel-light');
                    } else {
                        slider.closest('.permission').find('i').removeClass('text-riel-light');
                    }
                }, 0);


            });
        });
    </script>
@endpush
