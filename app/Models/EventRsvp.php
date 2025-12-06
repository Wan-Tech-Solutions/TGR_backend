<?php
declare(strict_types=1);
namespace App\Models;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class EventRsvp extends Model implements Auditable
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
            'event_id',
            'email',
            'response',
            'message',
            'responded_at'
        ];

        /**
        * The attributes that should be cast.
        *
        * @var array<string, string>
        */
        protected $casts = [
            'responded_at' => 'datetime',
        ];

        public function event()
        {
            return $this->belongsTo(Event::class);
        }
}
