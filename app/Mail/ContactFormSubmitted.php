<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Name of contact.
     * @var String
     */
    protected $name;
    /**
     * Email of contact.
     * @var String
     */
    protected $email;
    /**
     * Message of contact.
     * @var String
     */
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $contact_name, String $contact_email, String $contact_message)
    {
        $this->name = $contact_name;
        $this->email = $contact_email;
        $this->message = $contact_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Request From Supremeglobal.com.my')
            ->view('emails.contactformsubmitted')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'message_text' => $this->message,
            ]);
    }
}
