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
        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['verbal', 'written', 'final', 'suspension'])->default('verbal');
            $table->string('subject');
            $table->text('description');
            $table->text('violation_details');
            $table->date('incident_date');
            $table->date('warning_date');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->text('corrective_action_required')->nullable();
            $table->date('review_date')->nullable();
            $table->enum('status', ['active', 'acknowledged', 'resolved', 'expired'])->default('active');
            $table->foreignId('issued_by')->constrained('users');
            $table->foreignId('witnessed_by')->nullable()->constrained('users');
            $table->timestamp('acknowledged_at')->nullable();
            $table->text('employee_response')->nullable();
            $table->json('attachments')->nullable();
            $table->boolean('affects_performance_review')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warnings');
    }
};
