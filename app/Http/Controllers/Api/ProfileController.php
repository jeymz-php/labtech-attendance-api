<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EmailChangeOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $staff = $request->user();

        $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'profile_picture' => ['nullable', 'image', 'max:4096'],
            'remove_picture' => ['nullable', 'in:0,1'],
        ]);

        $staff->full_name = $request->full_name;

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

        return response()->json([
            'message' => 'Profile updated.',
            'staff' => [
                'staff_id' => $staff->staff_id,
                'full_name' => $staff->full_name,
                'campus' => $staff->campus,
                'program' => $staff->program,
                'email' => $staff->email,
                'profile_picture_url' => $staff->profile_picture_url,
            ],
        ]);
    }

    public function requestEmailChange(Request $request)
    {
        $staff = $request->user();

        $request->validate([
            'new_email' => ['required', 'email', 'max:150', 'unique:staff,email'],
        ]);

        if (strtolower($request->new_email) === strtolower($staff->email)) {
            return response()->json(['message' => 'This is already your current email address.'], 422);
        }

        $otp = (string) random_int(100000, 999999);

        $staff->pending_email = $request->new_email;
        $staff->email_otp = Hash::make($otp);
        $staff->email_otp_expires_at = now()->addMinutes(10);
        $staff->save();

        Mail::to($request->new_email)->send(new EmailChangeOtpMail($staff, $otp));

        return response()->json(['message' => 'A verification code was sent to your new email address.']);
    }

    public function confirmEmailChange(Request $request)
    {
        $staff = $request->user();

        $request->validate([
            'otp' => ['required', 'string'],
        ]);

        if (! $staff->pending_email || ! $staff->email_otp) {
            return response()->json(['message' => 'No pending email change found.'], 422);
        }

        if ($staff->email_otp_expires_at && now()->greaterThan($staff->email_otp_expires_at)) {
            return response()->json(['message' => 'This code has expired. Please request a new one.'], 422);
        }

        if (! Hash::check($request->otp, $staff->email_otp)) {
            return response()->json(['message' => 'Incorrect verification code.'], 422);
        }

        $staff->email = $staff->pending_email;
        $staff->pending_email = null;
        $staff->email_otp = null;
        $staff->email_otp_expires_at = null;
        $staff->save();

        return response()->json([
            'message' => 'Email address updated.',
            'email' => $staff->email,
        ]);
    }

    public function changePassword(Request $request)
    {
        $staff = $request->user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->current_password, $staff->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }

        $staff->password = Hash::make($request->new_password);
        $staff->save();

        return response()->json(['message' => 'Password changed successfully.']);
    }
}