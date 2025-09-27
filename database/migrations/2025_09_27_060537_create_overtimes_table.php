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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('total_minutes');
            $table->decimal('hourly_rate', 8, 2);
            $table->decimal('total_amount', 10, 2);
            $table->text('reason');
            $table->text('work_description');
            $table->enum('status', ['pending', 'approved', 'rejected', 'paid'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_pre_approved')->default(false);
            $table->enum('overtime_type', ['regular', 'holiday', 'weekend'])->default('regular');
            $table->decimal('multiplier', 3, 2)->default(1.5); // 1.5x for regular overtime
            $table->timestamps();
            
            $table->index(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
