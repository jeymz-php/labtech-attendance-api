<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\OfficeSetting;
use App\Models\Staff;
use App\Models\StaffSchedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
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

        $blockReason = $this->checkAttendanceAllowed($staff, $now);
        if ($blockReason) {
            return response()->json(['message' => $blockReason], 403);
        }

        $today = $now->copy()->startOfDay();

        $existing = AttendanceLog::where('staff_id', $staff->id)
            ->whereDate('log_date', $today)
            ->first();

        if ($existing && $existing->time_in) {
            return response()->json(['message' => "{$staff->full_name} already timed in today."], 409);
        }

        $status = $this->determineStatus($staff, $now);

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

        $blockReason = $this->checkAttendanceAllowed($staff, $now);
        if ($blockReason) {
            return response()->json(['message' => $blockReason], 403);
        }

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
        $query = AttendanceLog::where('staff_id', $request->user()->id)->orderByDesc('log_date');

        if ($request->filled('from')) {
            $query->whereDate('log_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('log_date', '<=', $request->to);
        }

        $logs = $query->limit(200)->get()->map(function ($log) {
            return [
                'log_date' => $log->log_date->format('Y-m-d'),
                'time_in' => $log->time_in ? $log->time_in->timezone(self::TIMEZONE)->format('h:i A') : null,
                'time_out' => $log->time_out ? $log->time_out->timezone(self::TIMEZONE)->format('h:i A') : null,
                'status' => $log->status,
            ];
        });

        return response()->json(['logs' => $logs]);
    }

    public function reportPdf(Request $request)
    {
        $staff = $request->user();

        $query = AttendanceLog::where('staff_id', $staff->id)->orderByDesc('log_date');

        if ($request->filled('from')) {
            $query->whereDate('log_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('log_date', '<=', $request->to);
        }

        $logs = $query->get();

        $pdf = Pdf::loadView('pdf.attendance-report', [
            'staff' => $staff,
            'logs' => $logs,
            'generatedAt' => Carbon::now(self::TIMEZONE),
            'timezone' => self::TIMEZONE,
        ]);

        return $pdf->download('attendance-report-' . $staff->staff_id . '.pdf');
    }

    private function determineStatus(Staff $staff, Carbon $now): string
    {
        $settings = OfficeSetting::firstOrCreate([]);
        $dayOfWeek = (int) $now->format('w');

        $schedule = StaffSchedule::where('staff_id', $staff->id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        $baselineTime = ($schedule && $schedule->is_duty && $schedule->start_time)
            ? $schedule->start_time
            : $settings->open_time;

        $baseline = Carbon::parse($now->format('Y-m-d') . ' ' . $baselineTime, self::TIMEZONE);
        $lateCutoff = $baseline->copy()->addMinutes($settings->late_grace_minutes);

        return $now->greaterThan($lateCutoff) ? 'late' : 'on_time';
    }

    private function checkAttendanceAllowed(Staff $staff, Carbon $now): ?string
    {
        $settings = OfficeSetting::firstOrCreate([]);

        if ($settings->mode === 'force_closed') {
            return 'Attendance is currently closed by the LabTech Office.';
        }

        if ($settings->mode === 'normal') {
            $current = $now->format('H:i:s');

            if ($current < $settings->open_time || $current > $settings->close_time) {
                $openLabel = Carbon::parse($settings->open_time)->format('h:i A');
                $closeLabel = Carbon::parse($settings->close_time)->format('h:i A');
                return "Attendance is only allowed between {$openLabel} and {$closeLabel}.";
            }
        }

        $dayOfWeek = (int) $now->format('w');

        $schedule = StaffSchedule::where('staff_id', $staff->id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (! $schedule || ! $schedule->is_duty) {
            return "{$staff->full_name} is off duty today.";
        }

        return null;
    }

    private function findStaff(string $identifier): ?Staff
    {
        $identifier = trim($identifier);

        return Staff::where('staff_id', $identifier)
            ->orWhere('student_number', strtoupper($identifier))
            ->first();
    }
}