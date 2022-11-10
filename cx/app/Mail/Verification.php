<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verification extends Mailable
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
            ->to($this->user->email, $this->user->getName())
            ->subject(trans('pages/auth.verification_subject'))
            ->view('emails.auth.verification', [
                'user' => $this->user,
            ]);
    }
}
