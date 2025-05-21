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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('type'); // merit, need-based, athletic, etc.
            $table->decimal('amount', 10, 2);
            $table->string('amount_type'); // fixed, percentage
            $table->decimal('minimum_gpa', 3, 2)->nullable();
            $table->integer('minimum_credits')->nullable();
            $table->integer('duration_semesters')->nullable();
            $table->boolean('renewable')->default(false);
            $table->text('renewal_criteria')->nullable();
            $table->text('eligibility_criteria');
            $table->date('application_deadline')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status')->default('active'); // active, inactive
            $table->integer('max_recipients')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
