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
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->year('year');
            $table->integer('annual_leaves')->default(21);
            $table->integer('sick_leaves')->default(10);
            $table->integer('maternity_leaves')->default(90);
            $table->integer('paternity_leaves')->default(15);
            $table->integer('emergency_leaves')->default(5);
            $table->integer('compensatory_leaves')->default(0);
            $table->integer('used_annual_leaves')->default(0);
            $table->integer('used_sick_leaves')->default(0);
            $table->integer('used_maternity_leaves')->default(0);
            $table->integer('used_paternity_leaves')->default(0);
            $table->integer('used_emergency_leaves')->default(0);
            $table->integer('used_compensatory_leaves')->default(0);
            $table->timestamps();
            
            $table->unique(['user_id', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
