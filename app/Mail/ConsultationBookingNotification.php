<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationBookingNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $messageContent;

    /**
     * Create a new message instance.
     *
     * @param array $messageContent
     * @return void
     */
    public function __construct($messageContent)
    {
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank You for Booking a Consultation with TGR Africa')
                    ->view('emails.consultation_booking')
                    ->with(['messageContent' => $this->messageContent]);
    }
}
