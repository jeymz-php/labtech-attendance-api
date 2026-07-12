<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('pending_email')->nullable()->after('email');
            $table->string('email_otp')->nullable()->after('pending_email');
            $table->timestamp('email_otp_expires_at')->nullable()->after('email_otp');
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['pending_email', 'email_otp', 'email_otp_expires_at']);
        });
    }
};