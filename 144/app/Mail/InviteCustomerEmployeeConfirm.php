<?php

namespace App\Mail;

use App\Libs\UserInfo;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteCustomerEmployeeConfirm extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(UserInfo $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('riel.emails.register.email'), config('riel.emails.register.name'))
            ->to(config('riel.emails.register.email'), config('riel.emails.register.name'))
            ->subject(trans('emails.successful_activation'))
            ->view(
                'emails.invites.customer-employee-confirm',
                [
                    'user' => $this->user,
                ]
            );
    }
}
