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
        Schema::table('users', function (Blueprint $table) {
            // Security fields
            $table->boolean('two_factor_enabled')->default(false);
            
            // Preference fields
            $table->string('theme')->default('light');
            $table->string('font_size')->default('medium');
            $table->string('language')->default('en');
            $table->string('timezone')->default('UTC');
            $table->string('date_format')->default('MM/DD/YYYY');
            $table->boolean('high_contrast')->default(false);
            $table->boolean('reduced_motion')->default(false);
            $table->boolean('screen_reader')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_enabled',
                'theme',
                'font_size',
                'language',
                'timezone',
                'date_format',
                'high_contrast',
                'reduced_motion',
                'screen_reader'
            ]);
        });
    }
}; 