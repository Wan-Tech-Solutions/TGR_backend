<?php
declare (strict_types = 1);
namespace App\Models;

use App\Models\Traits\SaveToUpper;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
    use HasFactory;
    use UuidTrait;
    use SaveToUpper;
    use \OwenIt\Auditing\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

    /**
     * Get the permissions for the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];
}
