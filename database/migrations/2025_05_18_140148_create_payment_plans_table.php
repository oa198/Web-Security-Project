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
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('total_amount', 10, 2);
            $table->integer('number_of_installments');
            $table->decimal('installment_amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active'); // active, completed, cancelled
            $table->string('payment_frequency'); // monthly, bi-monthly, quarterly
            $table->text('notes')->nullable();
            $table->string('semester');
            $table->string('academic_year');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
