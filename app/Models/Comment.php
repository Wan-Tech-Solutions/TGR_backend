<?php
declare(strict_types=1);
namespace App\Models;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Comment extends Model implements Auditable
{
    use HasFactory;
     use UuidTrait;
      use \OwenIt\Auditing\Auditable;
    /**
        * The attributes that are mass assignable.
        *
        * @var array<int, string>
        */
        protected $fillable = ['name', 'email', 'message', 'blog_id', 'parent_id'];

        // Define relationships
        public function replies()
        {
            return $this->hasMany(Comment::class, 'parent_id');
        }

        public function blog()
        {
            return $this->belongsTo(Blog::class);
        }

        public function parent()
        {
            return $this->belongsTo(Comment::class, 'parent_id');
        }
        /**
        * The attributes that should be cast.
        *
        * @var array<string, string>
        */
        protected $casts = [

        ];
}
