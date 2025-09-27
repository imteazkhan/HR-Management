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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->string('position')->nullable();
            $table->date('join_date');
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['manager_id', 'employee_id']); // Prevent duplicate assignments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
