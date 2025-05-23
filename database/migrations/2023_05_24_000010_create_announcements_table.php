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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('target_audience')->default('all'); // all, students, faculty, staff, department, course, section
            $table->unsignedBigInteger('target_id')->nullable(); // ID of the specific target if applicable
            $table->string('importance')->default('normal'); // low, normal, high, urgent
            $table->dateTime('publish_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('show_on_dashboard')->default(true);
            $table->boolean('send_email')->default(false);
            $table->boolean('send_notification')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
