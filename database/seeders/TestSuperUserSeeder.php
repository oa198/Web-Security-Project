<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class TestSuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a superuser with all permissions
        $superuser = User::firstOrCreate(
            ['email' => 'superuser@test.com'],
            [
                'name' => 'Test Superuser',
                'password' => Hash::make('Test@12345'),
                'email_verified_at' => now(),
            ]
        );

        // Assign all roles to the superuser
        $superuser->assignRole(['admin', 'student', 'professor', 'department_head', 'financial_officer']);
        
        // Give direct permissions to all actions
        $allPermissions = Permission::all();
        $superuser->syncPermissions($allPermissions);

        // Create student profile for the superuser if it doesn't exist
        if (!$superuser->student) {
            $student = Student::create([
                'user_id' => $superuser->id,
                'student_id' => 'SUPER-TEST-001',
                'program' => 'Computer Science', 
                'department_id' => 1, // Default department ID, adjust as needed
                'level' => 'Graduate',
                'credits_completed' => 120,
                'gpa' => 4.0,
                'academic_standing' => 'Excellent',
                'admission_date' => now()->subYears(3),
                'expected_graduation_date' => now()->addYears(1),
                'financial_hold' => false,
                'academic_hold' => false
            ]);
        }

        // No need to create a professor profile as the model doesn't exist in this project

        $this->command->info('Superuser created with email: superuser@test.com and password: Test@12345');
    }
}
