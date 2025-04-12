<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $attendances = Attendance::with('breaktimes', 'user')
            ->whereDate('created_at', $date)
            ->get();

        foreach ($attendances as $attendance) {
            $this->calculateTimes($attendance);
        }

        $dateFormatted = Carbon::parse($date)->format('Y/m/d');

        return view('admin.attendance.admin_list', compact('attendances', 'date', 'dateFormatted'));
    }

    
    public function approve($id)
    {
        $attendance = Attendance::findOrFail($id);

        if (!$attendance->is_locked) {
            return redirect()->route('admin.attendance.detail', $id)->with('info', 'すでに承認されています。');
        }

        $attendance->update([
            'is_locked' => false
        ]);

        return redirect()->route('admin.attendance.detail', $id)->with('success', '修正リクエストを承認しました。');
    }

    
    public function staffAttendance($user_id)
    {
        $user = User::findOrFail($user_id);
        $attendances = $user->attendances()->with('breaktimes')->orderBy('created_at', 'desc')->get();

        foreach ($attendances as $attendance) {
            $this->calculateTimes($attendance);
        }

        return view('admin.attendance.staff', compact('user', 'attendances'));
    }

    
    public function exportCSV(Request $request)
    {
        $attendances = Attendance::with('user', 'breaktimes')
            ->orderBy('created_at', 'desc')
            ->get();

        $csvData = [];
        $csvData[] = ['ユーザー名', '日付', '出勤', '退勤', '休憩', '合計'];

        foreach ($attendances as $attendance) {
            $this->calculateTimes($attendance);

            $csvData[] = [
                $attendance->user->name ?? '不明',
                optional($attendance->created_at)->format('Y/m/d') ?? '',
                optional($attendance->clock_in)->format('H:i') ?? '未設定',
                optional($attendance->clock_out)->format('H:i') ?? '未設定',
                $attendance->total_break_time ?? '未設定',
                $attendance->total_time ?? '未設定',
            ];
        }

        $filename = 'attendance_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->stream(
            function () use ($csvData) {
                $handle = fopen('php://output', 'w');
                fwrite($handle, "\xEF\xBB\xBF");

                foreach ($csvData as $line) {
                    fputcsv($handle, $line);
                }
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }

   
    private function calculateTimes(&$attendance)
    {
        $totalBreakTime = 0;

        foreach ($attendance->breaktimes as $breaktime) {
            if ($breaktime->break_start_time && $breaktime->break_end_time) {
                $startTime = Carbon::parse($breaktime->break_start_time);
                $endTime = Carbon::parse($breaktime->break_end_time);
                $breakDuration = $startTime->diffInMinutes($endTime);
                $totalBreakTime += $breakDuration;
            }
        }

        $attendance->total_break_time = $this->convertMinutesToTimeFormat($totalBreakTime);

        if ($attendance->clock_in && $attendance->clock_out) {
            $workMinutes = $attendance->clock_out->diffInMinutes($attendance->clock_in);
            $attendance->total_time = $this->convertMinutesToTimeFormat(max(0, $workMinutes - $totalBreakTime));
        } else {
            $attendance->total_time = '未設定';
        }
    }

   
    private function convertMinutesToTimeFormat($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
