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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // null for company-wide schedules
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['shift', 'meeting', 'training', 'event', 'deadline'])->default('shift');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->json('participants')->nullable(); // Array of user IDs
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_pattern', ['daily', 'weekly', 'monthly'])->nullable();
            $table->json('recurrence_days')->nullable(); // For weekly: [1,2,3,4,5] for Mon-Fri
            $table->date('recurrence_end_date')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
