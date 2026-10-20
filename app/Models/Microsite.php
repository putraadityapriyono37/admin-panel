<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Microsite extends Model
{
    protected $fillable = ['name', 'slug', 'domain', 'is_active', 'settings'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_microsite');
    }
}