<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'request_clock_in',
        'request_clock_out',
        'request_break_start_time',
        'request_break_end_time',
        'request_reason',
        'request_status',
        'remarks', 
        'is_locked',
    ];

    protected $casts = [
        'request_clock_in' => 'datetime',
        'request_clock_out' => 'datetime',
        'request_break_start_time' => 'datetime',
        'request_break_end_time' => 'datetime',
    ];


    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function breaktimes()
    {
        return $this->hasMany(Breaktime::class, 'attendance_id');
    }
}

