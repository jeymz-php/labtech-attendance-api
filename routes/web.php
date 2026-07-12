<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\StaffController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/{staff}', [StaffController::class, 'show'])->name('staff.show');
        Route::post('/staff/{staff}/approve', [StaffController::class, 'approve'])->name('staff.approve');
        Route::post('/staff/{staff}/disable', [StaffController::class, 'disable'])->name('staff.disable');
        Route::post('/staff/{staff}/reactivate', [StaffController::class, 'reactivate'])->name('staff.reactivate');
    });
});