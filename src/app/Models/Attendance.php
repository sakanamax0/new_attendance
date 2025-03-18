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
        'status' => AttendanceStatus::class, // Enumを適用
    ];

    /**
     * 勤怠ステータスに応じたラベルを返す
     *
     * @return string
     */
    public function getStatusLabel(): string
    {
        return $this->status->label(); // AttendanceStatusのlabel()を呼び出し
    }

    /**
     * 勤務時間計算（休憩時間を考慮）
     */
    public function calculateTotalHours(): void
    {
        // 勤務時間計算のロジックは breaktime モデルに移動
    }

    /**
     * 勤怠のステータスをリセット
     */
    public function resetForNextDay()
    {
        // ステータスを "勤務外" にリセット
        $this->status = AttendanceStatus::OFF_DUTY;
        $this->save();
    }

    /**
     * ユーザー情報とのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * breaktime モデルとのリレーション
     * 勤怠に関連する休憩時間のデータを取得
     */
    public function breaktimes()
    {
        return $this->hasMany(Breaktime::class);
    }

    /**
     * attendance_details モデルとのリレーション
     * 勤怠の修正申請データを取得
     */
    public function details()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
}
