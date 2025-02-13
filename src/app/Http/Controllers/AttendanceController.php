<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $status = $user->attendance_status; // 仮定：ユーザーに「attendance_status」フィールドがある
        $currentDateTime = now()->format('Y-m-d H:i:s');

        return view('attendance.index', compact('status', 'currentDateTime'));
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();

        if ($user->attendance_status !== '勤務外') {
            return redirect()->back()->with('error', '既に出勤済みです。');
        }

        $user->attendance_status = '勤務中';
        $user->save();

        return redirect()->route('attendance.index')->with('success', '出勤しました。');
    }

    public function breakStart(Request $request)
    {
        $user = Auth::user();

        if ($user->attendance_status !== '勤務中') {
            return redirect()->back()->with('error', '休憩を開始できません。');
        }

        $user->attendance_status = '休憩中';
        $user->save();

        return redirect()->route('attendance.index')->with('success', '休憩を開始しました。');
    }

    public function breakEnd(Request $request)
    {
        $user = Auth::user();

        if ($user->attendance_status !== '休憩中') {
            return redirect()->back()->with('error', '休憩を終了できません。');
        }

        $user->attendance_status = '勤務中';
        $user->save();

        return redirect()->route('attendance.index')->with('success', '休憩を終了しました。');
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();

        if ($user->attendance_status !== '勤務中') {
            return redirect()->back()->with('error', '退勤を行えません。');
        }

        $user->attendance_status = '退勤済';
        $user->save();

        return redirect()->route('attendance.index')->with('success', 'お疲れ様でした。');
    }
}
