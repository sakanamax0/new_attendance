<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AttendanceController;

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::put('/attendance/{id}/approve', [AttendanceController::class, 'approve'])->name('admin.attendance.approve');
    Route::get('/attendance/{id}', [AttendanceController::class, 'detail'])->name('admin.attendance.detail');
});