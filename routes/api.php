<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/attendance/kiosk/time-in', [AttendanceController::class, 'kioskTimeIn']);
Route::post('/attendance/kiosk/time-out', [AttendanceController::class, 'kioskTimeOut']);
Route::get('/attendance/today-all', [AttendanceController::class, 'todayAll']);
Route::get('/office-hours', [ScheduleController::class, 'officeHours']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/attendance/today', [AttendanceController::class, 'todayLog']);
    Route::get('/attendance/history', [AttendanceController::class, 'history']);
    Route::get('/attendance/report-pdf', [AttendanceController::class, 'reportPdf']);
    Route::get('/schedule', [ScheduleController::class, 'mySchedule']);

    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/profile/email/request-change', [ProfileController::class, 'requestEmailChange']);
    Route::post('/profile/email/confirm-change', [ProfileController::class, 'confirmEmailChange']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);
});