<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // 日付取得（リクエストがなければ今日）
        $date = $request->input('date', Carbon::today()->toDateString());

        // 指定日の日次勤怠データを取得
        $attendances = Attendance::whereDate('date', $date)->get();

        return view('admin.attendance.list', compact('attendances', 'date'));
    }

    public function approve($id)
    {
        $attendance = Attendance::findOrFail($id);

        // すでに承認済みなら処理しない
        if (!$attendance->is_locked) {
            return redirect()->route('admin.attendance.detail', $id)->with('info', 'すでに承認されています。');
        }

        // ロック解除（修正リクエストを承認）
        $attendance->update([
            'is_locked' => false
        ]);

        return redirect()->route('admin.attendance.detail', $id)->with('success', '修正リクエストを承認しました。');
    }
}
