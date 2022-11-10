<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketFeedback extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $email;
    public $name;
    public $phone;
    public $content;

    /**
     * Create a new message instance.
     *
     * @param mixed $email
     * @param mixed $name
     * @param mixed $phone
     * @param mixed $content
     */
    public function __construct($email, $name, $phone, $content)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('riel.emails.ticket.email'), config('riel.emails.ticket.name'))
            ->to($this->email, $this->name)
            ->subject('Hibajegy')
            ->view(
                'emails.tickets.feedback-to-user',
                [
                    'email' => $this->email,
                    'name' => $this->name,
                    'phone' => $this->phone,
                    'content' => $this->content,
                ]
            );
    }
}
