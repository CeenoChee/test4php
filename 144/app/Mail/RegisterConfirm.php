<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterConfirm extends Mailable
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
        return $this->from(config('riel.emails.register.email'), config('riel.emails.register.name'))
            ->to(config('riel.emails.register.email'), config('riel.emails.register.name'))

            ->subject(trans('pages/auth.new_register'))
            ->view('emails.auth.register-confirm', [
                'user' => $this->user,
            ]);
    }
}
