<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\OfficeSettingsController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaffScheduleController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
        Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
        Route::post('/staff/{staff}/update', [StaffController::class, 'update'])->name('staff.update');
        Route::post('/staff/{staff}/approve', [StaffController::class, 'approve'])->name('staff.approve');
        Route::post('/staff/{staff}/disable', [StaffController::class, 'disable'])->name('staff.disable');
        Route::post('/staff/{staff}/reactivate', [StaffController::class, 'reactivate'])->name('staff.reactivate');

        Route::get('/staff/{staff}/schedule', [StaffScheduleController::class, 'edit'])->name('staff.schedule.edit');
        Route::post('/staff/{staff}/schedule', [StaffScheduleController::class, 'update'])->name('staff.schedule.update');

        Route::get('/office-hours', [OfficeSettingsController::class, 'edit'])->name('office-hours.edit');
        Route::post('/office-hours', [OfficeSettingsController::class, 'update'])->name('office-hours.update');

        Route::get('/notifications/test', [NotificationTestController::class, 'edit'])->name('notifications.test');
    });
});