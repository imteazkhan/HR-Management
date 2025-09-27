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
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->integer('score')->nullable(); // 0-100
            $table->integer('completed_tasks')->default(0);
            $table->decimal('on_time_rate', 5, 2)->default(0.00); // Percentage
            $table->enum('rating', ['outstanding', 'excellent', 'good', 'satisfactory', 'needs_improvement'])->default('satisfactory');
            $table->text('comments')->nullable();
            $table->date('review_period_start');
            $table->date('review_period_end');
            $table->enum('status', ['draft', 'completed', 'approved'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
