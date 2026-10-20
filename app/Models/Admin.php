<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = ['name', 'username', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function microsites(): BelongsToMany
    {
        return $this->belongsToMany(Microsite::class, 'admin_microsite');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function homeUrl(): string
    {
        if ($this->isSuperAdmin()) {
            return route('admin.super.dashboard');
        }

        return route('admin.dashboard', $this->microsites()->firstOrFail());
    }

    public function canAccessMicrosite(int $micrositeId): bool
    {
        return $this->isSuperAdmin()
            || $this->microsites()->whereKey($micrositeId)->exists();
    }
}
