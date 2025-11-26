<?php
declare(strict_types=1);
namespace App\Models;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SentEmail extends Model implements Auditable
{
    use HasFactory;
    use UuidTrait;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'sender_id',
        'recipient_email',
        'recipient_name',
        'subject',
        'message',
        'attachment',
        'cc',
        'bcc',
        'status',
        'error_message',
        'sent_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the sender (user) who sent this email
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Scope to get sent emails
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope to get pending emails
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get failed emails
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'sent' => 'success',
            'pending' => 'warning',
            'failed' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get status badge icon
     */
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'sent' => 'fas fa-check-circle',
            'pending' => 'fas fa-hourglass-half',
            'failed' => 'fas fa-times-circle',
            default => 'fas fa-question-circle',
        };
    }
}
