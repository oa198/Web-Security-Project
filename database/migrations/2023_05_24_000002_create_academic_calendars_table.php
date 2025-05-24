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
        Schema::create('academic_calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_term_id')->constrained()->onDelete('cascade');
            $table->string('event_type'); // academic, holiday, deadline, etc.
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_holiday')->default(false);
            $table->boolean('is_campus_closed')->default(false);
            $table->string('color_code')->nullable();
            $table->string('visibility')->default('public'); // public, students, faculty, staff
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_calendars');
    }
};
