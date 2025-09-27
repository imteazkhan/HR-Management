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
        Schema::create('manager_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('email_notifications')->default(true);
            $table->boolean('push_notifications')->default(false);
            $table->boolean('weekly_reports')->default(true);
            $table->boolean('auto_approve_leaves')->default(false);
            $table->integer('team_size_limit')->default(20);
            $table->json('notification_preferences')->nullable();
            $table->timestamps();
            
            $table->unique('user_id'); // One settings record per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_settings');
    }
};
