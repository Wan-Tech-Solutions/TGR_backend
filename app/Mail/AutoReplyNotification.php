<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AutoReplyNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $messageContent;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($messageContent)
    {
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('Thank You for Contacting TGR Africa')
                    ->view('emails.auto_reply') // Create this view for the user auto-reply email
                    ->with(['messageContent' => $this->messageContent]);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */


    /**
     * Get the attachments for the message.
     *
     * @return array
     */

}
