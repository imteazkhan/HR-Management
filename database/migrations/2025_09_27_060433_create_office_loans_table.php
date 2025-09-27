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
        Schema::create('office_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('loan_type'); // Equipment, Advance, etc.
            $table->decimal('amount', 12, 2);
            $table->text('purpose');
            $table->date('issue_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'issued', 'returned', 'overdue', 'lost'])->default('pending');
            $table->text('description')->nullable();
            $table->json('items')->nullable(); // For equipment loans
            $table->string('condition_issued')->nullable();
            $table->string('condition_returned')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users');
            $table->timestamp('issued_at')->nullable();
            $table->foreignId('returned_to')->nullable()->constrained('users');
            $table->timestamp('returned_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_loans');
    }
};
