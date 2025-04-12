<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceDetail;
use App\Models\Attendance;

class StampCorrectionRequestController extends Controller
{
    // 修正申請一覧画面
    public function index()
    {
        $pendingRequests = AttendanceDetail::where('remarks', 0)->get(); // 承認待ち
        $approvedRequests = AttendanceDetail::where('remarks', 1)->get(); // 承認済み

        return view('admin.stamp_correction_request.list', compact('pendingRequests', 'approvedRequests'));
    }

    // 修正申請の詳細画面を表示
    public function showApprovalForm($id)
    {
        // 勤怠情報（attendance）、ユーザー（user）、休憩時間（breaktimes）を読み込む
        $detail = AttendanceDetail::with([
            'attendance.user',
            'attendance.breaktimes'
        ])->findOrFail($id);

        return view('admin.stamp_correction_request.approve', compact('detail'));
    }

    // 修正申請を承認する
    public function approve(Request $request, $id)
    {
        $detail = AttendanceDetail::with('attendance')->findOrFail($id);

        // 修正申請のステータスを承認済みに更新
        $detail->remarks = 1; // 承認済み
        $detail->save();

        // 申請に紐づく勤怠情報も更新
        if ($detail->attendance) {
            $attendance = $detail->attendance;

            // 勤怠情報の status カラムを "承認済み" に更新
            // "承認済み" を示す値として例えば 1 を設定
            $attendance->status = 1; // 1 は承認済みを示す例
            $attendance->save();
        }

        return redirect()->route('admin.stamp_correction_request.list')
                         ->with('success', '修正申請を承認しました');
    }

    // 修正申請を再送信する
    public function resendCorrectionRequest($id)
    {
        $detail = AttendanceDetail::findOrFail($id);

        // 修正申請を承認待ちに戻す
        $detail->remarks = 0; // 承認待ちに戻す
        $detail->save();

        // 勤怠情報（attendance）の状態も再送信に戻す
        if ($detail->attendance) {
            $attendance = $detail->attendance;
            $attendance->status = 0; // 承認待ちに戻す
            $attendance->save();
        }

        return redirect()->route('admin.stamp_correction_request.list')
                         ->with('success', '修正申請が再送信されました');
    }
}
