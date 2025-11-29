<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Consultation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * Daily capacity for consultations
     */
    public const DAILY_CAPACITY = 2;

    /**
     * Hourly rate for consultations in USD
     */
    public const HOURLY_RATE = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference',
        'name',
        'email',
        'dial_code',
        'phone',
        'nationality',
        'country_of_residence',
        'consultation_interest',
        'consultation_hours',
        'scheduled_for',
        'quoted_amount',
        'status',
        'payment_status',
        'payment_reference',
        'consultation_notes',
        'admin_notes',
        'meta',
        'rebook_parent_id',
        'rebook_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_for' => 'date',
        'quoted_amount' => 'integer',
        'consultation_hours' => 'integer',
        'rebook_count' => 'integer',
        'meta' => 'array',
    ];

    /**
     * Get all payments for this consultation
     */
    public function payments(): HasMany
    {
        return $this->hasMany(ConsultationPayment::class);
    }

    /**
     * Get all rebook logs for this consultation
     */
    public function rebookLogs(): HasMany
    {
        return $this->hasMany(RebookLog::class);
    }

    /**
     * Scope to get pending consultations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get confirmed consultations
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope to get completed consultations
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}

