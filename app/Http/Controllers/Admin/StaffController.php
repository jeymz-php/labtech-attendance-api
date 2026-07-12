<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\StaffApprovedMail;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        return redirect()
            ->route('admin.staff.index')
            ->with('success', "{$staff->full_name} disabled.");
    }

    public function reactivate(Staff $staff)
    {
        $staff->update(['status' => 'active']);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', "{$staff->full_name} reactivated.");
    }
}