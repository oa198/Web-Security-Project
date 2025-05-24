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
        Schema::create('program_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('required_credits')->default(3);
            $table->string('min_grade')->default('C');
            $table->string('requirement_type')->default('core'); // core, elective, general_education
            $table->integer('semester_recommended')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate requirements
            $table->unique(['program_id', 'course_id', 'requirement_type'], 'prog_req_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_requirements');
    }
};
