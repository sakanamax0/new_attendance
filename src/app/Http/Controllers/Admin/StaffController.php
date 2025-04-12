<?PHP

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User; // スタッフ一覧を取得するため

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::all(); // ユーザー一覧を取得（適宜修正）
        return view('admin.staff.list', compact('staffs'));
    }

        // スタッフの詳細表示
    public function show($id)
    {
        $user = User::findOrFail($id); // IDからユーザーを取得
        $attendances = $user->attendances()->orderBy('created_at', 'desc')->get(); // 勤怠情報を取得
        return view('admin.attendance.staff', compact('user', 'attendances'));
    }
    
}
