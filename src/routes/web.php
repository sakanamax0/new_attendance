<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceDetailController;  
use App\Http\Controllers\BreaktimeController;  
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController; // エイリアスを設定

// ユーザー登録
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ユーザーログイン・ログアウト
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 勤怠管理（ログイン必須）
Route::middleware('auth')->prefix('attendance')->group(function () {
    // 出勤・退勤
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');

    // 休憩時間管理
    Route::post('/{attendance_id}/break/start', [BreaktimeController::class, 'start'])->name('attendance.breakStart');
    Route::post('/{attendance_id}/break/end', [BreaktimeController::class, 'end'])->name('attendance.breakEnd');

    // 勤怠一覧
    Route::get('/list', [AttendanceController::class, 'list'])->name('attendance.list');

    // 勤怠詳細
    Route::get('/{id}/detail', [AttendanceDetailController::class, 'detail'])->name('attendance.detail');

    // 勤怠編集・更新をAttendanceDetailControllerに移動
    Route::get('/{id}/edit', [AttendanceDetailController::class, 'edit'])->name('attendance.edit');
    Route::put('/{id}/update', [AttendanceDetailController::class, 'update'])->name('attendance.update');
});

// 管理者用の勤怠一覧
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/attendance/list', [AdminAttendanceController::class, 'index'])->name('admin.attendance.list');
});
