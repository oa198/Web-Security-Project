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
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('student_id', 20)->unique();
                $table->string('national_id', 20)->nullable();
                $table->text('address')->nullable();
                $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
                $table->string('program')->nullable();
                $table->integer('credits_completed')->default(0);
                $table->decimal('gpa', 3, 2)->default(0.00);
                $table->string('academic_standing')->default('Good Standing');
                $table->string('advisor')->nullable();
                $table->string('level')->default('Freshman');
                $table->date('admission_date')->nullable();
                $table->date('expected_graduation_date')->nullable();
                $table->boolean('financial_hold')->default(false);
                $table->boolean('academic_hold')->default(false);
                $table->timestamps();
            });
        } else {
            // Add the fields if they don't exist
            Schema::table('students', function (Blueprint $table) {
                if (!Schema::hasColumn('students', 'national_id')) {
                    $table->string('national_id', 20)->nullable()->after('student_id');
                }
                
                if (!Schema::hasColumn('students', 'address')) {
                    $table->text('address')->nullable()->after('national_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the entire students table, just remove the columns we added
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                if (Schema::hasColumn('students', 'national_id')) {
                    $table->dropColumn('national_id');
                }
                
                if (Schema::hasColumn('students', 'address')) {
                    $table->dropColumn('address');
                }
            });
        }
    }
};
