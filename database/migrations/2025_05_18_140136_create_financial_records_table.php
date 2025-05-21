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
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->unique();
            $table->string('type'); // tuition, fee, payment, refund, scholarship
            $table->decimal('amount', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->string('description');
            $table->string('status'); // pending, paid, refunded, waived
            $table->string('payment_method')->nullable(); // credit card, bank transfer, cash
            $table->string('reference_number')->nullable();
            $table->string('semester');
            $table->string('academic_year');
            $table->foreignId('payment_plan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('receipt_number')->nullable();
            $table->date('due_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};
