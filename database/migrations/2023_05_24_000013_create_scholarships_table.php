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
            $table->text('description')->nullable();
            $table->string('type'); // merit, need-based, athletic, etc.
            $table->decimal('amount', 10, 2);
            $table->string('amount_type')->default('fixed'); // fixed or percentage
            $table->decimal('minimum_gpa', 3, 2)->nullable();
            $table->integer('minimum_credits')->nullable();
            $table->integer('duration_semesters')->nullable();
            $table->boolean('renewable')->default(false);
            $table->text('renewal_criteria')->nullable();
            $table->text('eligibility_criteria')->nullable();
            $table->date('application_deadline')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('active'); // active, inactive, expired
            $table->integer('max_recipients')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Create pivot table for student-scholarship relationship
        Schema::create('student_scholarship', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');
            $table->decimal('amount_awarded', 10, 2);
            $table->date('award_date');
            $table->date('valid_from');
            $table->date('valid_until')->nullable();
            $table->string('status')->default('active'); // active, expired, revoked
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate awards
            $table->unique(['student_id', 'scholarship_id', 'award_date'], 'scholarship_award_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_scholarship');
        Schema::dropIfExists('scholarships');
    }
};
