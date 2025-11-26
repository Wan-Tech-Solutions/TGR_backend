<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RebookReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Consultation $consultation)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reschedule Your TGR Africa Consultation - Free Rebook Available'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.rebook_reminder',
            with: [
                'consultation' => $this->consultation,
                'rebooksRemaining' => 2 - ($this->consultation->rebook_count ?? 0),
                'bookingUrl' => route('features.consult.book', [
                    'rebook_of' => $this->consultation->id,
                    'client_name' => $this->consultation->name,
                    'client_email' => $this->consultation->email,
                    'dial_code' => $this->consultation->dial_code,
                    'client_phone' => $this->consultation->phone,
                    'client_nationality' => $this->consultation->nationality,
                    'country_of_residence' => $this->consultation->country_of_residence,
                ]),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
