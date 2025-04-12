<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Breaktime;
use App\Enums\AttendanceStatus; 

class BreaktimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    public function start($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);

        
        if ($attendance->status !== AttendanceStatus::WORKING) {
            return redirect()->back()->with('error', '勤務中のみ休憩を開始できます。');
        }

        
        $attendance->update(['status' => AttendanceStatus::BREAK]); 

        
        Breaktime::create([
            'attendance_id' => $attendance->id,
            'break_start_time' => now(),
        ]);

        return redirect()->route('user.attendance.index')->with('success', '休憩を開始しました。');
    }

  
    public function end($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);

        
        if ($attendance->status !== AttendanceStatus::BREAK) {
            return redirect()->back()->with('error', '休憩中のみ休憩を終了できます。');
        }

        
        $attendance->update(['status' => AttendanceStatus::WORKING]); 

       
        $lastBreaktime = $attendance->breaktimes()->latest()->first();
        $lastBreaktime->update(['break_end_time' => now()]);

        return redirect()->route('user.attendance.index')->with('success', '休憩を終了しました。');
    }
}
