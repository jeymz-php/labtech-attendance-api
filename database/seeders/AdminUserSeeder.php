<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'labtech@ucc-caloocan.edu.ph'],
            [
                'name' => 'LabTech Admin Developer',
                'password' => Hash::make('Admin@1234'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'cambriblessmae.bsit@gmail.com'],
            [
                'name' => 'Mae Cambri',
                'password' => Hash::make('Admin@1234'),
            ]
        );
    }
}