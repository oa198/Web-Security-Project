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
        Schema::create('student_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('request_id')->unique();
            $table->string('type'); // course_withdrawal, retake, leave_of_absence, etc.
            $table->text('description');
            $table->string('status')->default('pending'); // pending, approved, rejected, in_progress
            $table->text('reason');
            $table->json('metadata')->nullable(); // Additional data based on request type
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete(); // If related to a course
            $table->foreignId('section_id')->nullable()->constrained()->nullOnDelete(); // If related to a section
            $table->string('semester');
            $table->string('academic_year');
            $table->date('submission_date');
            $table->date('decision_date')->nullable();
            $table->string('decision_by')->nullable();
            $table->text('decision_comments')->nullable();
            $table->string('advisor_status')->default('pending'); // pending, approved, rejected
            $table->string('department_status')->default('pending'); // pending, approved, rejected
            $table->string('registrar_status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_requests');
    }
};
