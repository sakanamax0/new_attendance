<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.user.register');
    }

    public function register(RegisterRequest $request)
    {
        // ユーザーを作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 会員登録後にログイン画面にリダイレクト
        return redirect()->route('login')->with('status', '登録が完了しました。ログインしてください。');
    }
}
