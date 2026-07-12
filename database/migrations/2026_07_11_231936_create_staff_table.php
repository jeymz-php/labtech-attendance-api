<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('staff_id')->unique();
            $table->string('full_name');
            $table->string('student_number')->unique();
            $table->enum('campus', [
                'Main Campus',
                'Congressional Extension Campus',
                'Camarin Extension Campus',
                'Bagong Silang Campus',
            ]);
            $table->enum('program', [
                'BS in Information Technology',
                'BS in Computer Science',
                'BS in Information Systems',
                'BS in Entertainment and Multimedia Computing',
            ]);
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['pending', 'active', 'disabled'])->default('pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
