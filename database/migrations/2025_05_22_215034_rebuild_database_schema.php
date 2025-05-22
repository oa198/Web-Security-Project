<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create Spatie Permission Tables
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type']);

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'model_id', 'model_type']);
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type']);

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        // 2. Create Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // 3. Create Faculties Table
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 4. Create Departments Table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('head_of_department')->nullable();
            $table->timestamps();
        });

        // 5. Create Courses Table
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('credits');
            $table->string('level');
            $table->string('semester');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Create Sections Table
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('capacity');
            $table->string('instructor');
            $table->string('room');
            $table->string('schedule');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. Create Students Table
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('student_id')->unique();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('program');
            $table->integer('credits_completed')->default(0);
            $table->decimal('gpa', 3, 2)->default(0.00);
            $table->string('academic_standing')->default('Good');
            $table->string('advisor')->nullable();
            $table->string('level');
            $table->date('admission_date');
            $table->date('expected_graduation_date')->nullable();
            $table->boolean('financial_hold')->default(false);
            $table->boolean('academic_hold')->default(false);
            $table->timestamps();
        });

        // 8. Create Enrollments Table
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->decimal('progress', 5, 2)->default(0.00);
            $table->timestamps();
        });

        // 9. Create Grades Table
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->decimal('points', 5, 2);
            $table->string('letter_grade');
            $table->text('feedback')->nullable();
            $table->timestamps();
        });

        // 10. Create Attendance Table
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 11. Create Financial Records Table
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('type');
            $table->string('description');
            $table->decimal('balance', 10, 2);
            $table->date('due_date')->nullable();
            $table->timestamps();
        });

        // 12. Create Payment Plans Table
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->integer('number_of_installments');
            $table->decimal('installment_amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // 13. Create Student Requests Table
        Schema::create('student_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('status')->default('pending');
            $table->text('description');
            $table->text('response')->nullable();
            $table->timestamps();
        });

        // 14. Create Documents Table
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('file_path');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // Add missing columns to documents table
        DB::statement('ALTER TABLE documents 
            ADD COLUMN title VARCHAR(255) AFTER student_id,
            ADD COLUMN file_size VARCHAR(255) AFTER file_path,
            ADD COLUMN uploaded_at TIMESTAMP NULL AFTER file_size');

        // 15. Create Schedules Table
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room');
            $table->string('type')->default('lecture');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 16. Create Notifications Table
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // 17. Create Failed Jobs Table
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // 18. Create Password Reset Tokens Table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 19. Create Personal Access Tokens Table
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // Set character set and collation for all tables
        $tables = [
            'permissions', 'roles', 'model_has_permissions', 'model_has_roles', 'role_has_permissions',
            'users', 'faculties', 'departments', 'courses', 'sections', 'students', 'enrollments',
            'grades', 'attendances', 'financial_records', 'payment_plans', 'student_requests',
            'documents', 'schedules', 'notifications', 'failed_jobs', 'password_reset_tokens',
            'personal_access_tokens'
        ];

        foreach ($tables as $table) {
            DB::statement("ALTER TABLE {$table} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order
        $tables = [
            'personal_access_tokens', 'password_reset_tokens', 'failed_jobs', 'notifications',
            'schedules', 'documents', 'student_requests', 'payment_plans', 'financial_records',
            'attendances', 'grades', 'enrollments', 'students', 'sections', 'courses',
            'departments', 'faculties', 'users', 'role_has_permissions', 'model_has_roles',
            'model_has_permissions', 'roles', 'permissions'
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
