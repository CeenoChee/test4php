<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The user instance.
     *
     * @var Request
     */
    public $email;
    private $name;
    private $content;

    /**
     * Create a new message instance.
     *
     * @param mixed $email
     * @param mixed $name
     * @param mixed $content
     */
    public function __construct($email, $name, $content)
    {
        $this->email = $email;
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('riel.emails.contact.email'), config('riel.emails.contact.name'))
            ->to(config('riel.emails.contact.email'), config('riel.emails.contact.name'))
            ->replyTo($this->email, $this->name)
            ->subject('[riel.hu] - Kapcsolat')
            ->view('emails.contact.colleague', [
                'email' => $this->email,
                'name' => $this->name,
                'content' => $this->content,
            ]);
    }
}
