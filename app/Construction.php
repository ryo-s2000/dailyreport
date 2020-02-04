<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Construction extends Model{
    protected $dates = [
        'start',
        'end'
    ];

    protected $guarded = [
        'id',
        'created_at'
    ];
}
