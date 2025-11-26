<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAddress extends Model
{
    use HasFactory;
    use UuidTrait;

    protected $table = 'email_addresses';

    protected $fillable = [
        'email',
        'label',
        'description',
        'password',
        'host',
        'port',
        'encryption',
        'is_active',
        'auto_sync',
        'last_synced_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'auto_sync' => 'boolean',
        'last_synced_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = ['password'];

    /**
     * Relationships
     */
    public function incomingEmails()
    {
        return $this->hasMany(IncomingEmail::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithAutoSync($query)
    {
        return $query->where('auto_sync', true);
    }

    /**
     * Methods
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
        return $this;
    }

    public function deactivate()
    {
        $this->update(['is_active' => false]);
        return $this;
    }

    public function toggleAutoSync()
    {
        $this->update(['auto_sync' => !$this->auto_sync]);
        return $this;
    }

    public function updateSyncTime()
    {
        $this->update(['last_synced_at' => now()]);
        return $this;
    }

    public function getDecryptedPassword()
    {
        if ($this->password) {
            return decrypt($this->password);
        }
        return null;
    }

    public function setEncryptedPassword($password)
    {
        if ($password) {
            $this->password = encrypt($password);
        }
        return $this;
    }

    /**
     * Accessors
     */
    public function getStatusBadgeAttribute()
    {
        return $this->is_active ? 'success' : 'danger';
    }

    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    public function getSyncStatusAttribute()
    {
        return $this->auto_sync ? 'Enabled' : 'Disabled';
    }
}
