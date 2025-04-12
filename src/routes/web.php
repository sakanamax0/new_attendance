<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceDetailController;
use App\Http\Controllers\BreaktimeController;
use App\Http\Controllers\StampCorrectionRequestController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\ShowController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StampCorrectionRequestController as AdminStampCorrectionRequestController;
use App\Http\Controllers\Admin\AdminLoginController;


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::middleware('auth')->prefix('attendance')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('user.attendance.index');
    Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');

    Route::post('/{attendance_id}/break/start', [BreaktimeController::class, 'start'])->name('attendance.breakStart');
    Route::post('/{attendance_id}/break/end', [BreaktimeController::class, 'end'])->name('attendance.breakEnd');

    Route::get('/list', [AttendanceController::class, 'list'])->name('attendance.list');
    Route::get('/{id}/detail', [AttendanceDetailController::class, 'detail'])->name('attendance.detail');
    Route::put('/{id}/update', [AttendanceDetailController::class, 'update'])->name('attendance.update');

    Route::get('/stamp_correction_request/list', [StampCorrectionRequestController::class, 'index'])->name('attendance.stamp_correction_request.list');
});


Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/list', [AdminAttendanceController::class, 'index'])->name('admin_list');
        Route::get('/staff/{user_id}', [AdminAttendanceController::class, 'staffAttendance'])->name('staff');
        Route::get('/staff/{user_id}/show', [ShowController::class, 'show'])->name('show');
        Route::patch('/staff/{user_id}/approve', [ShowController::class, 'approve'])->name('approve');
        Route::patch('/staff/{user_id}/reject', [ShowController::class, 'reject'])->name('reject');
        Route::patch('/staff/{user_id}/update', [ShowController::class, 'update'])->name('update');
        Route::get('/export_csv', [AdminAttendanceController::class, 'exportCSV'])->name('export_csv');
    });

    
    Route::get('/staff/list', [StaffController::class, 'index'])->name('staff.list');

    
    Route::prefix('stamp_correction_request')->name('stamp_correction_request.')->group(function () {
        Route::get('/list', [AdminStampCorrectionRequestController::class, 'index'])->name('list');
        Route::get('/approve/{attendance_correct_request}', [AdminStampCorrectionRequestController::class, 'showApprovalForm'])->name('approve');
        Route::post('/approve/{attendance_correct_request}', [AdminStampCorrectionRequestController::class, 'approve'])->name('approve.submit');
        Route::post('/resend/{id}', [AdminStampCorrectionRequestController::class, 'resendCorrectionRequest'])->name('resend');
    });
});
