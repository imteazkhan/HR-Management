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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->text('description')->nullable();
            $table->enum('type', ['national', 'religious', 'company', 'optional'])->default('company');
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_type', ['yearly', 'monthly'])->nullable();
            $table->json('applicable_departments')->nullable(); // null means all departments
            $table->json('applicable_designations')->nullable(); // null means all designations
            $table->boolean('is_active')->default(true);
            $table->year('year');
            $table->timestamps();
            
            $table->unique(['date', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
