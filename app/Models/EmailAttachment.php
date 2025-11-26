<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    use HasFactory;
    use UuidTrait;

    protected $table = 'email_attachments';

    protected $fillable = [
        'incoming_email_id',
        'filename',
        'mime_type',
        'size',
        'path',
    ];

    public function email()
    {
        return $this->belongsTo(IncomingEmail::class, 'incoming_email_id');
    }

    public function getFileSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
