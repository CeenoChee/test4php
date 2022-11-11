@if(Fct::isRielActive())
    @php
        $qty = isset($qty) ? $qty : 1;
        $deliveryTime = $product->getDeliveryTime($qty);
    @endphp
    <div class="shipping" data-label="@lang('pages/orders.shipping')">
        <div class="hover:cursor-pointer mt-4 text-xs rounded-md  ">

            <span class="shipping-info"
                  data-url="{{ route('product.delivery.time.info', ['locale' => app('Lang')->getLocale(), 'Termek_ID' => $product->Termek_ID, 'Mennyiseg' => $qty]) }}">
                <div class="md:flex-wrap lg:flex">
                    <div
                        class="w-[14px] h-[14px] mr-1 rounded-full inline-block @if($deliveryTime->isEmpty()) bg-red-500 @elseif($deliveryTime->isToday() || $deliveryTime->isNextBusinessDay()) bg-green-500 @else bg-orange-500 @endif"></div>

                        <span class="mr-2 font-semibold">@lang('pages/orders.shipping'):</span>


                            @if($deliveryTime->isEmpty())
                                <span>@lang('global.ask_about')</span>
                            @elseif($deliveryTime->isToday())
                                <span>@lang('dates.today') @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                            @elseif($deliveryTime->isNextBusinessDay())
                                <span class="">@lang('dates.next_business_day') @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                            @else
                                <span>{{ $deliveryTime->getDate() }} @if($deliveryTime->getTime() != '00:00:00') {{  $deliveryTime->getHour() }} @lang('dates.after') @endif</span>
                            @endif


                </div>
                <div class="popup-wrapper">
                    <div class="popup">
                        <div class="spinner"><i class="fal fa-spinner"></i></div>
                    </div>
                </div>
            </span>


        </div>

    </div>

@endif
