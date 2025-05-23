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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 8, 2)->default(0);
            $table->string('grade')->nullable();
            $table->string('status')->default('pending'); // pending, completed, reviewed, published
            $table->text('feedback')->nullable();
            $table->json('section_scores')->nullable();
            $table->boolean('is_absent')->default(false);
            $table->boolean('is_excused')->default(false);
            $table->text('absence_reason')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Unique constraint to prevent duplicate results
            $table->unique(['exam_id', 'student_id'], 'exam_result_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
