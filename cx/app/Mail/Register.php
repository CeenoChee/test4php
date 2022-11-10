<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Register extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): Register
    {
        return $this->from(config('riel.emails.register.email'), config('riel.emails.register.name'))
            ->to($this->user)
            ->subject(trans('pages/auth.register_success'))
            ->view('emails.auth.register', [
                'user' => $this->user,
            ]);
    }
}
