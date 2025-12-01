<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationAdminNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Consultation $consultation,
    ) {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Consultation Booking - {$this->consultation->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation-admin-notification',
            with: [
                'consultation' => $this->consultation,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
