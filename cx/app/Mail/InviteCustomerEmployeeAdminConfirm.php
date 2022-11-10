<?php

namespace App\Mail;

use App\Libs\UserInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteCustomerEmployeeAdminConfirm extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $adminUser;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(UserInfo $adminUser, UserInfo $user)
    {
        $this->adminUser = $adminUser;
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
            ->to($this->adminUser->getEmail(), $this->adminUser->getName())
            ->subject(trans('emails.the_employee_activated_himself'))
            ->view(
                'emails.invites.customer-employee-admin-confirm',
                [
                    'adminUser' => $this->adminUser,
                    'user' => $this->user,
                ]
            );
    }
}
