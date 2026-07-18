<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\OfficeSettingsController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StaffScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/download', function () {
    return view('download', ['version' => '1.0.0']);
})->name('app.download.page');

Route::get('/download/apk', function () {
    $path = public_path('downloads/labtech-attendance.apk');

    if (! file_exists($path)) {
        abort(404, 'App file not found.');
    }

    return response()->download($path, 'LabTech-Attendance.apk');
})->name('app.download');

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
        Route::post('/staff/{staff}/resend-password', [StaffController::class, 'resendPassword'])->name('staff.resend-password');

        Route::get('/staff/{staff}/schedule', [StaffScheduleController::class, 'edit'])->name('staff.schedule.edit');
        Route::post('/staff/{staff}/schedule', [StaffScheduleController::class, 'update'])->name('staff.schedule.update');

        Route::get('/office-hours', [OfficeSettingsController::class, 'edit'])->name('office-hours.edit');
        Route::post('/office-hours', [OfficeSettingsController::class, 'update'])->name('office-hours.update');

        Route::get('/notifications/test', [NotificationTestController::class, 'edit'])->name('notifications.test');
    });
});