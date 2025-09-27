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
        Schema::create('admin_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('leave_type', ['annual', 'sick', 'maternity', 'paternity', 'emergency', 'unpaid', 'compensatory', 'administrative']);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->text('reason');
            $table->enum('status', ['approved', 'cancelled'])->default('approved'); // Admin leaves are auto-approved
            $table->date('application_date');
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->boolean('is_half_day')->default(false);
            $table->enum('half_day_period', ['morning', 'afternoon'])->nullable();
            $table->string('delegate_to')->nullable(); // Who will handle responsibilities
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_leaves');
    }
};
