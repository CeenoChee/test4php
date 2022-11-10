<?php

namespace App\Http\Requests;

use App\Libs\Enums\Payment;
use App\Libs\Enums\ShipmentCost;
use Illuminate\Foundation\Http\FormRequest;

class BillingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return app('User')->isRielActive();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $payments = [
            Payment::PREPAYMENT,
        ];

        $user = app('User');

        if ($user->canTransfer()) {
            $payments[] = Payment::TRANSFER;
        }

        if ($user->canUseCreditCard()) {
            $payments[] = Payment::CREDIT_CARD;
        }

        $cart = app('Cart')->getCart();

        $shipmentCost = $cart->getShipmentCost();
        if ($shipmentCost->is(ShipmentCost::CUSTOMER)) {
            $payments[] = Payment::CASH;
        }

        if ($shipmentCost->is(ShipmentCost::SUPPLIER_FREE) && ! app('User')->isForeigner()) {
            $payments[] = Payment::CASH_ON_DELIVERY;
        }

        return [
            'payment' => 'required|in:' . implode(',', $payments),
        ];
    }

    public function messages()
    {
        return [
            'payment.required' => trans('pages/orders.payment_required'),
        ];
    }
}
