<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $guarded = [
        'id',
        'created_at'
    ];
}
