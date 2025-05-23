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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->integer('credits_required');
            $table->string('degree_type');
            $table->integer('duration_years');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('coordinator_name')->nullable();
            $table->string('coordinator_email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
