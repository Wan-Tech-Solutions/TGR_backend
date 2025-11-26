<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class IncomingEmail extends Model implements Auditable
{
    use HasFactory;
    use UuidTrait;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'incoming_emails';

    protected $fillable = [
        'user_id',
        'email_address_id',
        'from_email',
        'from_name',
        'to_email',
        'subject',
        'message',
        'html_message',
        'status',
        'is_read',
        'is_starred',
        'message_id',
        'thread_id',
        'cc',
        'bcc',
        'priority',
        'attachment_count',
        'received_at',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_starred' => 'boolean',
        'received_at' => 'datetime',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emailAddress()
    {
        return $this->belongsTo(EmailAddress::class);
    }

    public function attachments()
    {
        return $this->hasMany(EmailAttachment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(EmailTag::class, 'email_tag_mappings');
    }

    /**
     * Scopes
     */
    public function scopeInbox($query)
    {
        return $query->where('status', 'inbox')->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'inbox')->where('is_read', true);
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeTrash($query)
    {
        return $query->where('status', 'trash');
    }

    public function scopeSpam($query)
    {
        return $query->where('status', 'spam');
    }

    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('received_at', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     * Accessors
     */
    public function getPriorityBadgeAttribute()
    {
        $colors = [
            'low' => 'info',
            'normal' => 'secondary',
            'high' => 'danger',
        ];
        return $colors[$this->priority] ?? 'secondary';
    }

    public function getPriorityIconAttribute()
    {
        $icons = [
            'low' => 'fas fa-arrow-down',
            'normal' => 'fas fa-minus',
            'high' => 'fas fa-arrow-up',
        ];
        return $icons[$this->priority] ?? 'fas fa-minus';
    }

    public function getStatusBadgeAttribute()
    {
        $colors = [
            'inbox' => 'primary',
            'sent' => 'success',
            'draft' => 'warning',
            'trash' => 'danger',
            'spam' => 'dark',
        ];
        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Methods
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        return $this;
    }

    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
        return $this;
    }

    public function toggleStarred()
    {
        $this->update(['is_starred' => !$this->is_starred]);
        return $this;
    }

    public function moveToTrash()
    {
        $this->update(['status' => 'trash']);
        return $this;
    }

    public function restoreFromTrash()
    {
        $this->update(['status' => 'inbox']);
        return $this;
    }

    public function markAsSpam()
    {
        $this->update(['status' => 'spam']);
        return $this;
    }

    public function getPreviewText($length = 100)
    {
        $text = strip_tags($this->message ?? $this->html_message ?? '');
        $textLength = mb_strlen($text);
        return mb_substr($text, 0, $length) . ($textLength > $length ? '...' : '');
    }
}
