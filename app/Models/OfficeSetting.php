<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeSetting extends Model
{
    protected $fillable = [
        'mode',
        'open_time',
        'close_time',
        'late_grace_minutes',
    ];
}