<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\HiddenScope;

class Construction extends Model
{
    protected $dates = [
        'start',
        'end',
    ];

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new HiddenScope);
    }
}
