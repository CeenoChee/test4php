<div class="steps relative top-[10px] scale-[0.85] lg:scale-100">
    <ul class="timeline flex !justify-start">
        @foreach($order->getAvailableStatuses() as $status)

            <li class="w-[100px] li
                @if(!$loop->last && ($orderStatus->is(\App\Libs\Enums\OrderStatus::RECEIVABLE) || $orderStatus->is(\App\Libs\Enums\OrderStatus::TRANSPORTABLE))
                    || ($orderStatus->is(\App\Libs\Enums\OrderStatus::DELIVERED) || $orderStatus->is(\App\Libs\Enums\OrderStatus::RECEIVED)))
                    complete

                    @elseif($status->getValue() <= $orderStatus->getValue())
                    pending
                @endif">
                <div class="step-title order-step-title !px-0">
                    <h4 class="!font-normal"> {{ $status->getLabel() }} </h4>
                </div>
            </li>
        @endforeach

    </ul>
</div>
