<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Enums\AttendanceStatus; // AttendanceStatus Enumをインポート

class BreaktimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 休憩開始
    public function start($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);

        // ステータスが AttendanceStatus::WORKING かどうかを確認
        if ($attendance->status !== AttendanceStatus::WORKING) {
            return redirect()->back()->with('error', '勤務中のみ休憩を開始できます。');
        }

        // 休憩開始
        $attendance->update(['status' => AttendanceStatus::BREAK]); // Enumを使用してステータス更新

        // 休憩開始時間を追加
        Breaktime::create([
            'attendance_id' => $attendance->id,
            'break_start_time' => now(),
        ]);

        return redirect()->route('attendance.index')->with('success', '休憩を開始しました。');
    }

    // 休憩終了
    public function end($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);

        // ステータスが AttendanceStatus::BREAK かどうかを確認
        if ($attendance->status !== AttendanceStatus::BREAK) {
            return redirect()->back()->with('error', '休憩中のみ休憩を終了できます。');
        }

        // 休憩終了
        $attendance->update(['status' => AttendanceStatus::WORKING]); // Enumを使用してステータス更新

        // 最後の休憩を終了
        $lastBreaktime = $attendance->breaktimes()->latest()->first();
        $lastBreaktime->update(['break_end_time' => now()]);

        return redirect()->route('attendance.index')->with('success', '休憩を終了しました。');
    }
}
