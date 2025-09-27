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
        Schema::create('biometric_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_id');
            $table->string('biometric_id'); // Employee's biometric ID in the device
            $table->datetime('punch_time');
            $table->enum('punch_type', ['in', 'out', 'break_in', 'break_out']);
            $table->string('device_location')->nullable();
            $table->json('raw_data')->nullable(); // Store raw biometric data
            $table->boolean('is_processed')->default(false);
            $table->foreignId('processed_attendance_id')->nullable()->constrained('employee_attendances');
            $table->timestamps();
            
            $table->index(['user_id', 'punch_time']);
            $table->index(['device_id', 'punch_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biometric_attendances');
    }
};
