<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'attendance_type_id',
        'status',
        'date',
        'scanned_at',
    ];

        public function attendanceType()
    {
        return $this->belongsTo(AttendanceType::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
}
