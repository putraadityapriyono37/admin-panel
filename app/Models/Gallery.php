<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = ['microsite_id', 'image', 'caption'];

    public function microsite(): BelongsTo
    {
        return $this->belongsTo(Microsite::class);
    }
}