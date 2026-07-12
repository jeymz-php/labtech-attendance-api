<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\StaffApprovedMail;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $pending = Staff::where('status', 'pending')->latest()->get();
        $active = Staff::where('status', 'active')->latest()->get();
        $disabled = Staff::where('status', 'disabled')->latest()->get();

        return view('admin.staff.index', compact('pending', 'active', 'disabled'));
    }

    public function show(Staff $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'student_number' => ['required', 'string', 'max:30', Rule::unique('staff', 'student_number')->ignore($staff->id)],
            'campus' => ['required', Rule::in([
                'Main Campus',
                'Congressional Extension Campus',
                'Camarin Extension Campus',
                'Bagong Silang Campus',
            ])],
            'program' => ['required', Rule::in([
                'BS in Information Technology',
                'BS in Computer Science',
                'BS in Information Systems',
                'BS in Entertainment and Multimedia Computing',
            ])],
            'email' => ['required', 'email', 'max:150', Rule::unique('staff', 'email')->ignore($staff->id)],
            'profile_picture' => ['nullable', 'image', 'max:4096'],
            'remove_picture' => ['nullable', 'in:0,1'],
        ]);

        $staff->full_name = $request->full_name;
        $staff->student_number = strtoupper($request->student_number);
        $staff->campus = $request->campus;
        $staff->program = $request->program;
        $staff->email = $request->email;

        if ($request->hasFile('profile_picture')) {
            if ($staff->profile_picture) {
                Storage::disk('public')->delete($staff->profile_picture);
            }
            $staff->profile_picture = $request->file('profile_picture')->store('staff-photos', 'public');
        } elseif ($request->input('remove_picture') === '1') {
            if ($staff->profile_picture) {
                Storage::disk('public')->delete($staff->profile_picture);
            }
            $staff->profile_picture = null;
        }

        $staff->save();

        return redirect()->route('admin.staff.show', $staff)->with('success', 'Staff account updated.');
    }

    public function approve(Staff $staff)
    {
        $generatedPassword = Str::password(10, symbols: false);

        $staff->update([
            'status' => 'active',
            'password' => Hash::make($generatedPassword),
        ]);

        try {
            Mail::to($staff->email)->send(new StaffApprovedMail($staff, $generatedPassword));

            return redirect()
                ->route('admin.staff.index')
                ->with('success', "{$staff->full_name} approved. Password sent to {$staff->email}.");

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.staff.index')
                ->with('generated_password', $generatedPassword)
                ->with('approved_staff_id', $staff->staff_id)
                ->with('success', "{$staff->full_name} approved, but the email failed to send. See the password below.");
        }
    }

    public function disable(Staff $staff)
    {
        $staff->update(['status' => 'disabled']);

        return redirect()->route('admin.staff.index')->with('success', "{$staff->full_name} disabled.");
    }

    public function reactivate(Staff $staff)
    {
        $staff->update(['status' => 'active']);

        return redirect()->route('admin.staff.index')->with('success', "{$staff->full_name} reactivated.");
    }
}