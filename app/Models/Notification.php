<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'icon',
        'color',
        'notifiable_type',
        'notifiable_id',
        'related_type',
        'related_id',
        'read',
        'read_at',
    ];

    protected $casts = [
        'read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the parent notifiable model
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): self
    {
        $this->update([
            'read' => true,
            'read_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(): self
    {
        $this->update([
            'read' => false,
            'read_at' => null,
        ]);

        return $this;
    }

    /**
     * Get unread notifications
     */
    public static function unread()
    {
        return self::where('read', false)->latest();
    }

    /**
     * Create consultation booking notification
     */
    public static function createConsultationNotification(Consultation $consultation, string $type = 'consultation_booked'): self
    {
        $messages = [
            'consultation_booked' => "New consultation booked by {$consultation->name}",
            'consultation_confirmed' => "Consultation confirmed for {$consultation->name}",
            'consultation_completed' => "Consultation completed for {$consultation->name}",
            'consultation_cancelled' => "Consultation cancelled for {$consultation->name}",
        ];

        $icons = [
            'consultation_booked' => 'fas fa-calendar-plus',
            'consultation_confirmed' => 'fas fa-check-circle',
            'consultation_completed' => 'fas fa-handshake',
            'consultation_cancelled' => 'fas fa-times-circle',
        ];

        $colors = [
            'consultation_booked' => 'info',
            'consultation_confirmed' => 'success',
            'consultation_completed' => 'primary',
            'consultation_cancelled' => 'danger',
        ];

        $titles = [
            'consultation_booked' => 'New Consultation Booking',
            'consultation_confirmed' => 'Consultation Confirmed',
            'consultation_completed' => 'Consultation Completed',
            'consultation_cancelled' => 'Consultation Cancelled',
        ];

        return self::create([
            'type' => $type,
            'title' => $titles[$type] ?? 'Consultation Update',
            'message' => $messages[$type] ?? 'Consultation event occurred',
            'icon' => $icons[$type] ?? 'fas fa-bell',
            'color' => $colors[$type] ?? 'info',
            'notifiable_type' => User::class,
            'notifiable_id' => 1, // Super admin ID (adjust as needed for multi-admin)
            'related_type' => Consultation::class,
            'related_id' => $consultation->id,
            'read' => false,
        ]);
    }
}
