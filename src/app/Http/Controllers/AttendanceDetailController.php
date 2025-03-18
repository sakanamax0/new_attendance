<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use Carbon\Carbon;

class AttendanceDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 勤怠詳細ページ
    public function detail($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);
        $detail = $attendance->details()->latest()->get();

        return view('attendance.detail', compact('attendance', 'detail'));
    }

    // 勤怠詳細編集ページ
    public function edit($id)
    {
        $detail = AttendanceDetail::findOrFail($id);

        return view('attendance.edit', compact('detail'));
    }

    // 勤怠詳細更新
    public function update(Request $request, $id)
    {
        $request->validate([
            'request_clock_in' => 'required|date',
            'request_clock_out' => 'required|date',
            'request_break_start_time' => 'nullable|date',
            'request_break_end_time' => 'nullable|date',
            'request_reason' => 'required|string',
            'request_status' => 'required|in:pending,approved,rejected',
        ]);

        $detail = AttendanceDetail::findOrFail($id);
        $detail->update($request->all());

        return redirect()->route('attendance.detail', $detail->attendance_id)->with('success', '申請内容を更新しました。');
    }

    // 勤怠詳細の申請作成ページ
    public function create($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);

        return view('attendance.create_detail', compact('attendance'));
    }

    // 勤怠詳細の申請保存
    public function store(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'request_clock_in' => 'required|date',
            'request_clock_out' => 'required|date',
            'request_break_start_time' => 'nullable|date',
            'request_break_end_time' => 'nullable|date',
            'request_reason' => 'required|string',
            'request_status' => 'required|in:pending,approved,rejected',
        ]);

        AttendanceDetail::create($request->all());

        return redirect()->route('attendance.detail', $request->attendance_id)->with('success', '申請が完了しました。');
    }
}
