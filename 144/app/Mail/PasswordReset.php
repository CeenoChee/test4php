<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;
    public $token;

    /**
     * Reset constructor.
     *
     * @param $token
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS', 'regisztracio@riel.hu'), env('MAIL_FROM_NAME', 'RIEL Regisztráció'))
            ->subject('Elfelejtett jelszó')
            ->view('emails.auth.password-reset');
    }
}
