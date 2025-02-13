<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AttendanceController;

// ユーザー登録
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// 管理者ログイン
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::get('/dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard'); // ダッシュボード
});

// 勤怠管理
Route::prefix('attendance')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/start', [AttendanceController::class, 'startWork'])->name('attendance.start');
    Route::post('/break', [AttendanceController::class, 'startBreak'])->name('attendance.break');
    Route::post('/resume', [AttendanceController::class, 'resumeWork'])->name('attendance.resume');
    Route::post('/end', [AttendanceController::class, 'endWork'])->name('attendance.end');
});
