<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/attendance/kiosk/time-in', [AttendanceController::class, 'kioskTimeIn']);
Route::post('/attendance/kiosk/time-out', [AttendanceController::class, 'kioskTimeOut']);
Route::get('/attendance/today-all', [AttendanceController::class, 'todayAll']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/attendance/today', [AttendanceController::class, 'todayLog']);
    Route::get('/attendance/history', [AttendanceController::class, 'history']);
});