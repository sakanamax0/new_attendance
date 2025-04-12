<?PHP

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User; 

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::all(); 
        return view('admin.staff.list', compact('staffs'));
    }

       
    public function show($id)
    {
        $user = User::findOrFail($id); 
        $attendances = $user->attendances()->orderBy('created_at', 'desc')->get(); 
        return view('admin.attendance.staff', compact('user', 'attendances'));
    }
    
}
