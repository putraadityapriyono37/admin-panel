<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMicrosite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use BelongsToMicrosite;

    protected $fillable = ['microsite_id', 'name', 'sort_order'];

    public function microsite(): BelongsTo
    {
        return $this->belongsTo(Microsite::class);
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
