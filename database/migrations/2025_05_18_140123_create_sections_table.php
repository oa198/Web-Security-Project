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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('section_number');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->integer('capacity');
            $table->integer('enrolled')->default(0);
            $table->boolean('is_full')->default(false);
            $table->integer('waitlist_capacity')->default(0);
            $table->integer('waitlist_count')->default(0);
            $table->string('room')->nullable();
            $table->string('days'); // e.g., 'MW' for Monday and Wednesday
            $table->time('start_time');
            $table->time('end_time');
            $table->date('registration_open')->nullable();
            $table->date('registration_close')->nullable();
            $table->string('semester'); // e.g., 'Fall 2025'
            $table->string('academic_year'); // e.g., '2025-2026'
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['course_id', 'section_number', 'semester', 'academic_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
