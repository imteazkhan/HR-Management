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
        Schema::create('loan_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_loan_id')->constrained()->onDelete('cascade');
            $table->integer('installment_number');
            $table->decimal('amount', 10, 2);
            $table->decimal('principal_amount', 10, 2);
            $table->decimal('interest_amount', 10, 2);
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue', 'partial'])->default('pending');
            $table->text('payment_method')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->decimal('penalty_amount', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['personal_loan_id', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_installments');
    }
};
