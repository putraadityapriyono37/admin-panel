<?php

namespace App\Models\Scopes;

use App\Support\CurrentMicrosite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MicrositeScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $current = app(CurrentMicrosite::class)->get();

        if ($current) {
            $builder->where($model->qualifyColumn('microsite_id'), $current->id);
        }
    }
}
