<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;

class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin'); 
    }

    public function show($user_id)
    {
        $attendance = Attendance::where('user_id', $user_id)->firstOrFail();
        $breaktimes = Breaktime::where('attendance_id', $attendance->id)->get();

        return view('admin.attendance.show', compact('attendance', 'breaktimes'));
    }

    public function update(Request $request, $attendance_id)
    {
        $request->validate([
            'request_clock_in' => 'required|date_format:H:i',
            'request_clock_out' => 'required|date_format:H:i|after:request_clock_in',
            'break_start_time.*' => 'required|date_format:H:i',
            'break_end_time.*' => 'required|date_format:H:i|after:break_start_time.*',
            'reason' => 'nullable|filled|max:255',
        ]);

        $attendance = Attendance::findOrFail($attendance_id);
        $attendance->update([
            'clock_in' => $request->request_clock_in,
            'clock_out' => $request->request_clock_out,
            'reason' => $request->reason,
        ]);

        // ✅ 一度全ての休憩時間を削除してから再登録
        $attendance->breaktimes()->delete();

        if ($request->has('break_start_time')) {
            foreach ($request->break_start_time as $index => $start_time) {
                $attendance->breaktimes()->create([
                    'break_start_time' => $start_time,
                    'break_end_time' => $request->break_end_time[$index],
                ]);
            }
        }

        session()->flash('success', '勤怠情報が更新されました。');

        // ✅ breaktimes も取得してビューに渡す
        $breaktimes = $attendance->breaktimes;

        return view('admin.attendance.show', compact('attendance', 'breaktimes'));
    }
}
