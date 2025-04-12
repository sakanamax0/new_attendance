<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended(route('attendance.index')); // 勤怠画面へ
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
