<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breaktime extends Model
{
    use HasFactory;

    protected $table = 'breaktime';

    protected $fillable = [
        'attendance_id',
        'break_start_time',
        'break_end_time',
    ];

    // Attendance モデルとのリレーション
    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }
}
