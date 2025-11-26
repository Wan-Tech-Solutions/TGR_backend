<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationPayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'consultation_id',
        'provider',
        'amount',
        'currency',
        'status',
        'provider_reference',
        'reference',
        'initialize_payload',
        'verification_payload',
        'paid_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'integer',
        'initialize_payload' => 'array',
        'verification_payload' => 'array',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the consultation this payment belongs to
     */
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }
}
