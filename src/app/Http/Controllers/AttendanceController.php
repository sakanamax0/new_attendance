<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Enums\AttendanceStatus;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $attendance = Attendance::where('user_id', $user->id)->latest()->first();

       
        $currentDate = Carbon::today();

       
        if ($attendance && $attendance->created_at->toDateString() !== $currentDate->toDateString()) {
            $this->resetForNextDay($attendance);
        }

        $status = $attendance ? $attendance->getStatusLabel() : '勤務外';
        $message = ($attendance && $attendance->status === AttendanceStatus::FINISHED) ? 'お疲れ様でした。' : '';

        return view('user.attendance.index', compact('status', 'message', 'attendance'));
    }


    public function checkIn()
    {
        $currentDate = Carbon::today();
        $attendance = Attendance::where('user_id', Auth::id())->whereDate('created_at', $currentDate)->first();

        if ($attendance && $attendance->status === AttendanceStatus::WORKING) {
            return redirect()->back()->with('error', 'すでに出勤中です。');
        }

        Attendance::create([
            'user_id' => Auth::id(),
            'clock_in' => now(),
            'status' => AttendanceStatus::WORKING
        ]);

        return redirect()->route('user.attendance.index')->with('success', '出勤しました。');
    }

    public function checkOut()
    {
        $attendance = $this->getCurrentAttendance();
        if (!$attendance) {
            return redirect()->route('user.attendance.index')->with('error', '出勤記録が見つかりません。');
        }

        $attendance->update(['status' => AttendanceStatus::FINISHED, 'clock_out' => now()]);
        $attendance->calculateTotalHours();
        $this->resetForNextDay($attendance);

        return redirect()->route('user.attendance.index')->with('success', '退勤しました。');
    }

    public function resetForNextDay(Attendance $attendance)
    {
        $attendance->status = AttendanceStatus::OFF_DUTY;
        $attendance->save();
    }

    private function getCurrentAttendance()
    {
        return Attendance::where('user_id', Auth::id())->whereNull('clock_out')->latest()->first();
    }

   
    public function list(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));

        try {
            $currentMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        } catch (\Exception $e) {
            $currentMonth = now()->startOfMonth();
        }

        $prevMonth = $currentMonth->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentMonth->copy()->addMonth()->format('Y-m');

        $attendances = Attendance::whereBetween('clock_in', [$currentMonth, $currentMonth->copy()->endOfMonth()])
            ->orderBy('clock_in', 'asc')
            ->get();

        return view('user.attendance.list', compact('attendances', 'currentMonth', 'prevMonth', 'nextMonth'));
    }

    
    public function showDetails($attendance_id)
    {
        return redirect()->route('user.attendance.details', $attendance_id);
    }
}
