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

    protected $appends = ['number_with_year'];

    public function getNumberWithYearAttribute()
    {
        return '('. $this->year . ')' . $this->number;
    }

    public function dailyreports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Dailyreport::class);
    }
}
