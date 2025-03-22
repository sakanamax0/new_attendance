<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceDetail;

class StampCorrectionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 申請一覧（一般ユーザー）
    public function index()
    {
        // 承認待ちと承認済みの申請を取得
        $pendingRequests = AttendanceDetail::where('remarks', 0)->get(); // 承認待ち
        $approvedRequests = AttendanceDetail::where('remarks', 1)->get(); // 承認済み

        return view('attendance.stamp_correction_request_list', compact('pendingRequests', 'approvedRequests'));
    }
}
