<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $full_name;
    public $email;
    public $country_of_residence;
    public $nationality;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($full_name, $email, $country_of_residence, $nationality, $subject, $message)
    {
        $this->full_name = $full_name;
        $this->email = $email;
        $this->$country_of_residence = $country_of_residence;
        $this->$nationality = $nationality;
        $this->$subject = $subject;
        $this->message = $message;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact')
            ->subject('New Contact Form Submission')
            ->with([
                'name' => $this->full_name,
                'email' => $this->email,
                'country_of_residence' => $this->country_of_residence,
                'nationality' => $this->nationality,
                'subject' => $this->subject,
                'messageContent' => $this->message,
            ]);
    }


    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Contact Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
