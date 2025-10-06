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
        // This migration was trying to add columns that already exist
        // We'll leave this empty since the columns are already in the base departments table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't need to do anything here since we didn't add any columns
    }
};
