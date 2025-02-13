<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // ログインフォームの表示
    public function showLoginForm()
    {
        return view('admin.login'); // ビューのパス
    }

    // ログイン処理
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard'); // 管理者用ダッシュボードへのリダイレクト
        }

        // ログイン失敗時のエラーメッセージ
        return back()->withErrors(['login' => 'ログイン情報が登録されていません。']);
    }

    // ダッシュボード画面の表示
    public function dashboard()
    {
        return view('admin.dashboard'); // ダッシュボード用ビュー
    }
}
