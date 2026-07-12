<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:150'],
            'student_number' => ['required', 'string', 'max:30', 'unique:staff,student_number'],
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
            'email' => ['required', 'email', 'max:150', 'unique:staff,email'],
            'profile_picture' => ['nullable', 'image', 'max:4096'],
        ];
    }
}