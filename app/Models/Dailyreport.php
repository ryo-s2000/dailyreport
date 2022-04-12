<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dailyreport extends Model
{
    protected $dates = [
        'date',
    ];

    protected $guarded = [
        'id',
        'created_at',
    ];

    public function construction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Construction::class);
    }
}
