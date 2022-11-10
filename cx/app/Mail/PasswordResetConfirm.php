<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetConfirm extends Mailable
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
     * Reset constructor.
     *
     * @param $token
     */
    public function __construct(User $user)
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
        return $this->from(env('MAIL_FROM_ADDRESS', 'regisztracio@riel.hu'), env('MAIL_FROM_NAME', 'RIEL Regisztráció'))
            ->to($this->user)
            ->subject(trans('pages/account.the_password_changed'))
            ->view('emails.auth.password-reset-confirm');
    }
}
