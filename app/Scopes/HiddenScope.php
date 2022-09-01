<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HiddenScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->whereNotNull('hidden_at');
    }
}
