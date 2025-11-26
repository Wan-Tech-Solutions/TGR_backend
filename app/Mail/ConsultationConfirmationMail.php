<?php
declare(strict_types=1);
namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ConsultationConfirmationMail extends Mailable
{
    public function __construct(public Consultation $consultation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consultation Booking Confirmation - TGR Africa',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation-confirmation',
        );
    }
}
