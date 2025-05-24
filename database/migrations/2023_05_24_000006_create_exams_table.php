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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('academic_term_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('exam_type'); // midterm, final, quiz, etc.
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->integer('duration_minutes');
            $table->string('location')->nullable();
            $table->decimal('weight', 5, 2)->default(0); // Percentage weight in course grade
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('total_marks');
            $table->integer('passing_marks');
            $table->boolean('is_published')->default(false);
            $table->boolean('allow_retake')->default(false);
            $table->boolean('is_proctored')->default(false);
            $table->boolean('is_online')->default(false);
            $table->json('allowed_materials')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
