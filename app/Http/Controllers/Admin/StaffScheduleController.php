<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffSchedule;
use Illuminate\Http\Request;

class StaffScheduleController extends Controller
{
    public function edit(Staff $staff)
    {
        $schedules = StaffSchedule::where('staff_id', $staff->id)->get()->keyBy('day_of_week');

        return view('admin.staff.schedule', compact('staff', 'schedules'));
    }

    public function update(Request $request, Staff $staff)
    {
        foreach (range(0, 6) as $day) {
            $isDuty = $request->boolean("duty.$day");

            StaffSchedule::updateOrCreate(
                ['staff_id' => $staff->id, 'day_of_week' => $day],
                [
                    'is_duty' => $isDuty,
                    'start_time' => $isDuty ? $request->input("start.$day") : null,
                    'end_time' => $isDuty ? $request->input("end.$day") : null,
                ]
            );
        }

        return redirect()->route('admin.staff.schedule.edit', $staff)->with('success', 'Schedule updated.');
    }
}