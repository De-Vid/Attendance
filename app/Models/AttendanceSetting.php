<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    protected $fillable = [
        'morning_check_in',
        'morning_check_out', 
        'afternoon_check_in',
        'afternoon_check_out'
    ];

    protected $casts = [
        'morning_check_in'    => 'string',
        'morning_check_out'   => 'string',
        'afternoon_check_in'  => 'string',
        'afternoon_check_out' => 'string',
    ];
}
