<?php

namespace App\Http\Controllers\Admin;  

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    
    public function showLoginForm()
    {
        
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.attendance.admin_list');
        }

        
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->invalidate(); 
            session()->regenerateToken();
            return redirect()->route('login'); 
        }

        return view('auth.admin.login'); 
    }

   
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

       
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->invalidate(); 
            session()->regenerateToken();
        }


        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.attendance.admin_list'); 
        }

        return back()->withErrors(['login' => 'ログイン情報が登録されていません。']);
    }
}
