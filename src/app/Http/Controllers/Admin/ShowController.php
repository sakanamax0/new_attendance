<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceDetail;

class ShowController extends Controller
{
    /**
     * 申請の承認処理
     */
    public function approve($id)
    {
        $detail = AttendanceDetail::findOrFail($id);
        $detail->update(['request_status' => 'approved']);

        return back()->with('success', '申請を承認しました。');
    }

    /**
     * 申請の却下処理
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string',
        ]);

        $detail = AttendanceDetail::findOrFail($id);
        $detail->update([
            'request_status' => 'rejected',
            'reject_reason' => $request->reject_reason,
        ]);

        return back()->with('success', '申請を却下しました。');
    }

    /**
     * 勤怠詳細ページの表示
     */
    public function show($id)
    {
        $attendance = AttendanceDetail::with('user')->findOrFail($id);
        return view('admin.attendance.show', compact('attendance'));
    }
}
