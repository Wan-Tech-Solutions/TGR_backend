<?php

namespace App\Listeners;

use App\Events\ConsultationCreated;
use App\Mail\ConsultationAdminNotificationMail;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendConsultationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ConsultationCreated $event): void
    {
        $consultation = $event->consultation;

        // Create notification record for admin dashboard popup
        Notification::createConsultationNotification(
            $consultation,
            'consultation_booked'
        );

        // Send email notification to admin
        try {
            $adminEmail = config('mail.from.address') ?? 'admin@tgrafrica.com';
            Mail::to($adminEmail)->send(new ConsultationAdminNotificationMail($consultation));
        } catch (\Exception $e) {
            \Log::warning('Failed to send admin consultation notification email', [
                'consultation_id' => $consultation->id,
                'email' => $adminEmail,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
