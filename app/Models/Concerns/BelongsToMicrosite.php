<?php

namespace App\Models\Concerns;

use App\Models\Scopes\MicrositeScope;
use App\Support\CurrentMicrosite;

trait BelongsToMicrosite
{
    protected static function bootBelongsToMicrosite(): void
    {
        static::addGlobalScope(new MicrositeScope);

        static::creating(function ($model) {
            if (! $model->microsite_id) {
                $current = app(CurrentMicrosite::class)->get();

                if ($current) {
                    $model->microsite_id = $current->id;
                }
            }
        });
    }
}
