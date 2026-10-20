<?php

namespace App\Models;

use App\Models\Concerns\BelongsToMicrosite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use BelongsToMicrosite;

    protected $fillable = ['microsite_id', 'image', 'caption'];

    public function microsite(): BelongsTo
    {
        return $this->belongsTo(Microsite::class);
    }
}
