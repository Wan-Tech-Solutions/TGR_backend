<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTag extends Model
{
    use HasFactory;
    use UuidTrait;

    protected $table = 'email_tags';

    protected $fillable = [
        'user_id',
        'name',
        'color',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emails()
    {
        return $this->belongsToMany(IncomingEmail::class, 'email_tag_mappings');
    }
}
