<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AttendanceStatus;
use Carbon\CarbonImmutable;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'clock_in',
        'clock_out',
        'remarks',
        'is_locked',
    ];

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
        'status' => AttendanceStatus::class, 
    ];

    /**
     * 
     *
     * @return string
     */
    public function getStatusLabel(): string
    {
        return $this->status->label(); 
    }

    /**
     * 
     */
    public function calculateTotalHours(): void
    {
        // 勤務時間計算のロジックは breaktime モデルに移動
    }


    public function resetForNextDay()
    {
        
        $this->status = AttendanceStatus::OFF_DUTY;
        $this->save();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function breaktimes()
    {
        return $this->hasMany(Breaktime::class);
    }


    public function details()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}
