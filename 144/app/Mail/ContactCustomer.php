<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactCustomer extends Mailable
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
        $subject = app('Lang')->getLocale() === 'hu' ? '[riel.hu] - Kapcsolat' : '[riel.hu] - Contact';

        return $this->from(config('riel.emails.contact.email'), config('riel.emails.contact.name'))
            ->to($this->email, $this->name)
            ->subject($subject)
            ->view('emails.contact.customer', [
                'email' => $this->email,
                'name' => $this->name,
                'content' => $this->content,
            ]);
    }
}
