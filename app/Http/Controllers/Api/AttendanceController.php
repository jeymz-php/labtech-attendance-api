<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private const LATE_CUTOFF = '09:00:00';
    private const TIMEZONE = 'Asia/Manila';

    public function kioskTimeIn(Request $request)
    {
        $request->validate(['identifier' => ['required', 'string']]);

        $staff = $this->findStaff($request->identifier);

        if (! $staff) {
            return response()->json(['message' => 'Staff ID or Student Number not found.'], 404);
        }

        if ($staff->status !== 'active') {
            return response()->json(['message' => 'This account is not active yet.'], 403);
        }

        $now = Carbon::now(self::TIMEZONE);
        $today = $now->copy()->startOfDay();

        $existing = AttendanceLog::where('staff_id', $staff->id)
            ->whereDate('log_date', $today)
            ->first();

        if ($existing && $existing->time_in) {
            return response()->json(['message' => "{$staff->full_name} already timed in today."], 409);
        }

        $status = $now->format('H:i:s') > self::LATE_CUTOFF ? 'late' : 'on_time';

        $log = AttendanceLog::updateOrCreate(
            ['staff_id' => $staff->id, 'log_date' => $today],
            ['time_in' => $now, 'status' => $status]
        );

        return response()->json([
            'message' => 'Timed in successfully.',
            'staff_name' => $staff->full_name,
            'staff_id' => $staff->staff_id,
            'time' => $now->format('h:i A'),
            'status' => $status,
        ], 201);
    }

    public function kioskTimeOut(Request $request)
    {
        $request->validate(['identifier' => ['required', 'string']]);

        $staff = $this->findStaff($request->identifier);

        if (! $staff) {
            return response()->json(['message' => 'Staff ID or Student Number not found.'], 404);
        }

        $now = Carbon::now(self::TIMEZONE);
        $today = $now->copy()->startOfDay();

        $log = AttendanceLog::where('staff_id', $staff->id)
            ->whereDate('log_date', $today)
            ->first();

        if (! $log || ! $log->time_in) {
            return response()->json(['message' => "{$staff->full_name} needs to time in first."], 422);
        }

        if ($log->time_out) {
            return response()->json(['message' => "{$staff->full_name} already timed out today."], 409);
        }

        $log->update(['time_out' => $now]);

        return response()->json([
            'message' => 'Timed out successfully.',
            'staff_name' => $staff->full_name,
            'staff_id' => $staff->staff_id,
            'time' => $now->format('h:i A'),
        ]);
    }

    public function todayAll()
    {
        $today = Carbon::today(self::TIMEZONE);

        $logs = AttendanceLog::with('staff')
            ->whereDate('log_date', $today)
            ->orderByDesc('time_in')
            ->get()
            ->filter(fn ($log) => $log->staff !== null)
            ->map(function ($log) {
                return [
                    'staff_name' => $log->staff->full_name,
                    'staff_id' => $log->staff->staff_id,
                    'profile_picture_url' => $log->staff->profile_picture_url,
                    'time_in' => $log->time_in ? $log->time_in->timezone(self::TIMEZONE)->format('h:i A') : null,
                    'time_out' => $log->time_out ? $log->time_out->timezone(self::TIMEZONE)->format('h:i A') : null,
                    'status' => $log->status,
                ];
            })
            ->values();

        return response()->json(['logs' => $logs]);
    }

    public function todayLog(Request $request)
    {
        $staff = $request->user();

        $log = AttendanceLog::where('staff_id', $staff->id)
            ->whereDate('log_date', Carbon::today(self::TIMEZONE))
            ->first();

        return response()->json(['log' => $log]);
    }

    public function history(Request $request)
    {
        $logs = AttendanceLog::where('staff_id', $request->user()->id)
            ->orderByDesc('log_date')
            ->limit(30)
            ->get();

        return response()->json(['logs' => $logs]);
    }

    private function findStaff(string $identifier): ?Staff
    {
        $identifier = trim($identifier);

        return Staff::where('staff_id', $identifier)
            ->orWhere('student_number', strtoupper($identifier))
            ->first();
    }
}