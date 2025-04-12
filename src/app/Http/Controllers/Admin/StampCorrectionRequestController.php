<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceDetail;
use App\Models\Attendance;

class StampCorrectionRequestController extends Controller
{
    
    public function index()
    {
        $pendingRequests = AttendanceDetail::where('remarks', 0)->get(); 
        $approvedRequests = AttendanceDetail::where('remarks', 1)->get(); 

        return view('admin.stamp_correction_request.list', compact('pendingRequests', 'approvedRequests'));
    }

   
    public function showApprovalForm($id)
    {
        
        $detail = AttendanceDetail::with([
            'attendance.user',
            'attendance.breaktimes'
        ])->findOrFail($id);

        return view('admin.stamp_correction_request.approve', compact('detail'));
    }

   
    public function approve(Request $request, $id)
    {
        $detail = AttendanceDetail::with('attendance')->findOrFail($id);

        
        $detail->remarks = 1; 
        $detail->save();

        
        if ($detail->attendance) {
            $attendance = $detail->attendance;

            
           
            $attendance->status = 1; 
            $attendance->save();
        }

        return redirect()->route('admin.stamp_correction_request.list')
                         ->with('success', '修正申請を承認しました');
    }

    
    public function resendCorrectionRequest($id)
    {
        $detail = AttendanceDetail::findOrFail($id);

     
        $detail->remarks = 0; 
        $detail->save();

        
        if ($detail->attendance) {
            $attendance = $detail->attendance;
            $attendance->status = 0; 
            $attendance->save();
        }

        return redirect()->route('admin.stamp_correction_request.list')
                         ->with('success', '修正申請が再送信されました');
    }
}
