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

 
    public function index()
    {
      
        $pendingRequests = AttendanceDetail::where('remarks', 0)->get(); 
        $approvedRequests = AttendanceDetail::where('remarks', 1)->get(); 

        return view('user.stamp_correction_request.list', compact('pendingRequests', 'approvedRequests'));
    }
}
