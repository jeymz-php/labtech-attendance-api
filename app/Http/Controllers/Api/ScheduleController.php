<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfficeSetting;
use App\Models\StaffSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private const DAY_NAMES = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    public function mySchedule(Request $request)
    {
        $staff = $request->user();

        $schedules = StaffSchedule::where('staff_id', $staff->id)->get()->keyBy('day_of_week');

        $result = [];
        foreach (self::DAY_NAMES as $i => $name) {
            $s = $schedules->get($i);
            $result[] = [
                'day_of_week' => $i,
                'day_name' => $name,
                'is_duty' => $s ? (bool) $s->is_duty : false,
                'start_time' => ($s && $s->is_duty && $s->start_time) ? Carbon::parse($s->start_time)->format('h:i A') : null,
                'end_time' => ($s && $s->is_duty && $s->end_time) ? Carbon::parse($s->end_time)->format('h:i A') : null,
            ];
        }

        return response()->json(['schedule' => $result]);
    }

    public function officeHours()
    {
        $settings = OfficeSetting::firstOrCreate([]);

        return response()->json([
            'mode' => $settings->mode,
            'open_time' => Carbon::parse($settings->open_time)->format('h:i A'),
            'close_time' => Carbon::parse($settings->close_time)->format('h:i A'),
        ]);
    }
}