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
        Schema::create('personal_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->integer('tenure_months');
            $table->decimal('monthly_emi', 10, 2);
            $table->text('purpose');
            $table->date('application_date');
            $table->date('approval_date')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'disbursed', 'active', 'completed', 'defaulted'])->default('pending');
            $table->decimal('outstanding_amount', 12, 2)->default(0);
            $table->integer('paid_installments')->default(0);
            $table->date('next_due_date')->nullable();
            $table->json('guarantors')->nullable();
            $table->json('documents')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_loans');
    }
};
