<?php

namespace App\Http\Controllers\Admin;  

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // 管理者ログインフォームの表示
    public function showLoginForm()
    {
        // 管理者がすでにログインしている場合、管理者ページにリダイレクト
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.attendance.admin_list');
        }

        // 一般ユーザーがログインしている場合、ログアウトさせて一般ログインページにリダイレクト
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->invalidate(); // セッション破棄
            session()->regenerateToken();
            return redirect()->route('login'); // 一般ユーザーログインページへリダイレクト
        }

        return view('auth.admin.login'); // 管理者ログイン画面を表示
    }

    // 管理者ログイン処理
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // 一般ユーザーがログインしていたらログアウトさせる
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->invalidate(); 
            session()->regenerateToken();
        }

        // 管理者の認証処理
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.attendance.admin_list'); 
        }

        return back()->withErrors(['login' => 'ログイン情報が登録されていません。']);
    }
}
