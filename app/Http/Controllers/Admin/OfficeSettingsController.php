<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeSetting;
use Illuminate\Http\Request;

class OfficeSettingsController extends Controller
{
    public function edit()
    {
        $settings = OfficeSetting::firstOrCreate([]);

        return view('admin.office-hours.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'mode' => ['required', 'in:normal,force_open,force_closed'],
            'open_time' => ['nullable', 'date_format:H:i'],
            'close_time' => ['nullable', 'date_format:H:i'],
            'late_grace_minutes' => ['required', 'integer', 'min:0', 'max:120'],
        ]);

        $settings = OfficeSetting::firstOrCreate([]);

        $settings->update([
            'mode' => $request->mode,
            'open_time' => $request->open_time ?: $settings->open_time,
            'close_time' => $request->close_time ?: $settings->close_time,
            'late_grace_minutes' => $request->late_grace_minutes,
        ]);

        return redirect()->route('admin.office-hours.edit')->with('success', 'Office hours updated.');
    }
}