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
        Schema::create('prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('prerequisite_course_id')->constrained('courses')->onDelete('cascade');
            $table->string('min_grade')->default('C');
            $table->text('notes')->nullable();
            $table->boolean('can_be_concurrent')->default(false);
            $table->boolean('can_be_waived')->default(false);
            $table->timestamps();
            
            // Unique constraint to prevent duplicate prerequisites
            $table->unique(['course_id', 'prerequisite_course_id'], 'prereq_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prerequisites');
    }
};
