<?php

namespace App\Providers;

use Laravel\Fortify\Fortify;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // 登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ログイン画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // カスタム認証ロジック
        Fortify::authenticateUsing(function ($request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user; // ユーザーオブジェクトを返す
            }

            return null; // 認証失敗時は null を返す
        });
    }
}
