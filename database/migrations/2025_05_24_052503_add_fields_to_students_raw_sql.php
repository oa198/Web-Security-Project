<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if students table exists
        if (Schema::hasTable('students')) {
            // Check if national_id column exists
            $hasNationalId = DB::select("SHOW COLUMNS FROM students LIKE 'national_id'");
            if (empty($hasNationalId)) {
                DB::statement('ALTER TABLE students ADD COLUMN national_id VARCHAR(20) NULL AFTER student_id');
            }
            
            // Check if address column exists
            $hasAddress = DB::select("SHOW COLUMNS FROM students LIKE 'address'");
            if (empty($hasAddress)) {
                DB::statement('ALTER TABLE students ADD COLUMN address TEXT NULL AFTER national_id');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('students')) {
            // Check if national_id column exists before dropping
            $hasNationalId = DB::select("SHOW COLUMNS FROM students LIKE 'national_id'");
            if (!empty($hasNationalId)) {
                DB::statement('ALTER TABLE students DROP COLUMN national_id');
            }
            
            // Check if address column exists before dropping
            $hasAddress = DB::select("SHOW COLUMNS FROM students LIKE 'address'");
            if (!empty($hasAddress)) {
                DB::statement('ALTER TABLE students DROP COLUMN address');
            }
        }
    }
};
