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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('status'); // present, absent, excused, late
            $table->text('notes')->nullable();
            $table->time('check_in_time')->nullable(); // Time student checked in
            $table->boolean('excused_absence')->default(false);
            $table->text('excused_reason')->nullable();
            $table->foreignId('recorded_by')->constrained('users');
            $table->string('semester');
            $table->string('academic_year');
            $table->boolean('is_at_risk')->default(false); // Flag for at-risk students based on attendance
            $table->timestamps();
            
            $table->unique(['student_id', 'section_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
