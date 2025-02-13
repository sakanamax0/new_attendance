<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    public static function getCurrentStatus($userId)
    {
        // 最新の勤怠ステータスを取得
        return self::where('user_id', $userId)->latest()->first()->status ?? '勤務外';
    }

    public static function startWork($userId)
    {
        // 出勤処理（ステータスを勤務中に更新）
        return self::create([
            'user_id' => $userId,
            'status' => '勤務中',
            'start_time' => now(),
        ]);
    }

    public static function startBreak($userId)
    {
        // 休憩開始処理
        return self::create([
            'user_id' => $userId,
            'status' => '休憩中',
            'break_start_time' => now(),
        ]);
    }

    public static function resumeWork($userId)
    {
        // 勤務再開処理
        return self::create([
            'user_id' => $userId,
            'status' => '勤務中',
        ]);
    }

    public static function endWork($userId)
    {
        // 退勤処理
        return self::create([
            'user_id' => $userId,
            'status' => '退勤済',
            'end_time' => now(),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
