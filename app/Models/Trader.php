<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trader extends Model
{
    protected $guarded = [
        'id',
        'created_at',
    ];
}
