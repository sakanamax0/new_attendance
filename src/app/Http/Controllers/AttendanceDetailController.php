<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Breaktime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 勤怠詳細ページ（編集も含む）
    public function detail($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);
        $detail = $attendance->details()->latest()->first(); // 最新の詳細情報を取得

        // 休憩時間のデータを取得
        $breaktimes = $attendance->breaktimes;

        return view('user.attendance.detail', compact('attendance', 'detail', 'breaktimes'));
    }


public function update(Request $request, $id)
{
    $messages = [
        'request_clock_in.required' => '出勤時間を入力してください。',
        'request_clock_in.date_format' => '出勤時間の形式が正しくありません。',
        'request_clock_out.required' => '退勤時間を入力してください。',
        'request_clock_out.date_format' => '退勤時間の形式が正しくありません。',
        'request_clock_out.after' => '退勤時間は出勤時間より後の時間を入力してください。',
        'request_break_start_time.date_format' => '休憩開始時間の形式が正しくありません。',
        'request_break_start_time.after_or_equal' => '休憩開始時間は出勤時間と同じか後の時間を入力してください。',
        'request_break_end_time.date_format' => '休憩終了時間の形式が正しくありません。',
        'request_break_end_time.after' => '休憩終了時間は休憩開始時間より後の時間を入力してください。',
        'request_reason.required' => '申請理由を入力してください。',
    ];

    // バリデーション
    $request->validate([
        'request_clock_in' => 'required|date_format:H:i',
        'request_clock_out' => 'required|date_format:H:i|after:request_clock_in',
        'request_break_start_time' => 'nullable|array',
        'request_break_end_time' => 'nullable|array',
        'request_reason' => 'required|string',
    ], $messages);

    // AttendanceDetailが存在しない場合は新規作成
    $attendance = Attendance::findOrFail($id);
    $detail = $attendance->details()->first(); // attendance_detailsテーブルに関連するレコードを取得

    // attendance_detailsにレコードが無ければ新規作成
    if (!$detail) {
        $detail = AttendanceDetail::create([
            'attendance_id' => $attendance->id,
            'clock_in' => Carbon::parse($request->request_clock_in)->format('Y-m-d H:i'),
            'clock_out' => Carbon::parse($request->request_clock_out)->format('Y-m-d H:i'),
            'remarks' => 0, // 初期状態は修正申請中（承認待ち）
            'request_reason' => $request->request_reason, // 申請理由を保存
        ]);
    }

    // 既に承認待ちの場合は修正できない
    if ($detail->remarks == 0) {
        return redirect()->route('attendance.detail', $detail->attendance_id)
            ->with('error', '現在承認待ちのため修正できません。');
    }

    // 修正リクエストを送信（承認待ちにする）
    $detail->update([
        'clock_in' => Carbon::parse($request->request_clock_in)->format('Y-m-d H:i'),
        'clock_out' => Carbon::parse($request->request_clock_out)->format('Y-m-d H:i'),
        'remarks' => 0, // 承認待ち状態に変更
        'request_reason' => $request->request_reason, // 申請理由を保存
    ]);

    // 休憩時間の更新
    if ($request->has('break_start_time') && $request->has('break_end_time')) {
        foreach ($request->break_start_time as $index => $break_start_time) {
            $break_end_time = $request->break_end_time[$index];

            // 既存の休憩時間を更新する、または新たに休憩時間を追加
            $breaktime = Breaktime::where('attendance_id', $detail->attendance_id)->skip($index)->first();
            if ($breaktime) {
                $breaktime->update([
                    'break_start_time' => Carbon::parse($break_start_time)->format('Y-m-d H:i'),
                    'break_end_time' => Carbon::parse($break_end_time)->format('Y-m-d H:i'),
                ]);
            } else {
                Breaktime::create([
                    'attendance_id' => $detail->attendance_id,
                    'break_start_time' => Carbon::parse($break_start_time)->format('Y-m-d H:i'),
                    'break_end_time' => Carbon::parse($break_end_time)->format('Y-m-d H:i'),
                ]);
            }
        }
    }

    return redirect()->route('attendance.detail', $detail->attendance_id)
        ->with('success', '修正リクエストを送信しました。');
}
    // 管理者による承認
    public function approve($id)
    {
        $detail = AttendanceDetail::findOrFail($id);

        // 承認処理
        $detail->update([
            'remarks' => 1, // 承認済み状態に変更
        ]);

        return redirect()->route('attendance.detail', $detail->attendance_id)
            ->with('success', '修正リクエストを承認しました。');
    }
}
