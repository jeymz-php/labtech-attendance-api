<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStaffRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterStaffRequest $request)
    {
        $studentNumber = strtoupper($request->student_number);
        $staffId = $this->generateStaffId($studentNumber);

        $tempPassword = Str::random(12);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('staff-photos', 'public');
        }

        $staff = Staff::create([
            'staff_id' => $staffId,
            'full_name' => $request->full_name,
            'student_number' => $studentNumber,
            'campus' => $request->campus,
            'program' => $request->program,
            'email' => $request->email,
            'profile_picture' => $profilePicturePath,
            'password' => Hash::make($tempPassword),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Registration submitted. Your account is pending approval by the LabTech Office.',
            'staff_id' => $staff->staff_id,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'staff_id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $staff = Staff::where('staff_id', $request->staff_id)->first();

        if (! $staff || ! Hash::check($request->password, $staff->password)) {
            return response()->json([
                'message' => 'The staff ID or password is incorrect.',
            ], 401);
        }

        if ($staff->status !== 'active') {
            return response()->json([
                'message' => 'Your account is not active yet. Please wait for LabTech Office approval.',
            ], 403);
        }

        $token = $staff->createToken('labtech-app')->plainTextToken;

        return response()->json([
            'message' => 'Signed in.',
            'token' => $token,
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Signed out.']);
    }

    private function generateStaffId(string $studentNumber): string
    {
        return 'LT-' . strtoupper($studentNumber);
    }
}