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
        Schema::table('departments', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->text('description')->nullable()->after('name');
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null')->after('description');
            $table->boolean('is_active')->default(true)->after('manager_id');
            $table->integer('max_employees')->default(50)->after('is_active');
            $table->string('location')->nullable()->after('max_employees');
            $table->string('budget')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn([
                'name',
                'description', 
                'manager_id',
                'is_active',
                'max_employees',
                'location',
                'budget'
            ]);
        });
    }
};
