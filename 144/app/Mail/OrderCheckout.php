<?php

namespace App\Mail;

use App\Libs\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCheckout extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $email;
    private $name;
    private $order;

    public function __construct($email, $name, Order $order)
    {
        $this->email = $email;
        $this->name = $name;
        $this->order = $order;
    }

    public function build()
    {
        return $this->from(config('riel.emails.order.email'), config('riel.mails.order.name'))
            ->to($this->email, $this->name)
            ->subject(trans('emails.order_mail_subject', ['orderNumber' => $this->order->getNumber()]))
            ->view('emails.order-checkout', [
                'email' => $this->email,
                'name' => $this->name,
                'order' => $this->order,
            ]);
    }
}
