<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AcademicTerm;
use App\Models\AcademicCalendar;
use App\Models\Program;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $registrarRole = Role::firstOrCreate(['name' => 'registrar']);
        $facultyRole = Role::firstOrCreate(['name' => 'faculty']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        
        // Create demo users
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);
        
        $registrar = User::firstOrCreate(
            ['email' => 'registrar@example.com'],
            [
                'name' => 'Registrar User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $registrar->assignRole($registrarRole);
        
        $faculty = User::firstOrCreate(
            ['email' => 'faculty@example.com'],
            [
                'name' => 'Faculty User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $faculty->assignRole($facultyRole);
        
        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $student->assignRole($studentRole);
        
        // Create departments
        $scienceDept = Department::firstOrCreate(
            ['code' => 'SCI'],
            [
                'name' => 'Department of Science',
                'description' => 'All science related programs and courses',
            ]
        );
        
        $businessDept = Department::firstOrCreate(
            ['code' => 'BUS'],
            [
                'name' => 'Department of Business',
                'description' => 'Business administration and management programs',
            ]
        );
        
        $engineeringDept = Department::firstOrCreate(
            ['code' => 'ENG'],
            [
                'name' => 'Department of Engineering',
                'description' => 'Engineering disciplines and technologies',
            ]
        );
        
        // Create academic terms
        $currentYear = date('Y');
        $terms = [
            [
                'name' => 'Fall ' . $currentYear,
                'code' => 'FALL' . $currentYear,
                'start_date' => $currentYear . '-09-01',
                'end_date' => $currentYear . '-12-15',
                'registration_start' => $currentYear . '-08-01',
                'registration_end' => $currentYear . '-08-25',
                'status' => 'active',
            ],
            [
                'name' => 'Spring ' . ($currentYear + 1),
                'code' => 'SPR' . ($currentYear + 1),
                'start_date' => ($currentYear + 1) . '-01-15',
                'end_date' => ($currentYear + 1) . '-05-15',
                'registration_start' => $currentYear . '-12-01',
                'registration_end' => $currentYear . '-12-25',
                'status' => 'upcoming',
            ],
            [
                'name' => 'Summer ' . ($currentYear + 1),
                'code' => 'SUM' . ($currentYear + 1),
                'start_date' => ($currentYear + 1) . '-06-01',
                'end_date' => ($currentYear + 1) . '-08-15',
                'registration_start' => ($currentYear + 1) . '-05-01',
                'registration_end' => ($currentYear + 1) . '-05-25',
                'status' => 'upcoming',
            ],
        ];
        
        foreach ($terms as $termData) {
            AcademicTerm::firstOrCreate(
                ['code' => $termData['code']],
                $termData
            );
        }
        
        // Get the Fall term for events
        $fallTerm = AcademicTerm::where('code', 'FALL' . $currentYear)->first();
        
        // Create academic calendar events
        if ($fallTerm) {
            $events = [
                [
                    'name' => 'Classes Begin',
                    'description' => 'First day of classes for the Fall semester',
                    'start_date' => $fallTerm->start_date,
                    'end_date' => $fallTerm->start_date,
                    'event_type' => 'academic',
                    'academic_term_id' => $fallTerm->id,
                ],
                [
                    'name' => 'Add/Drop Deadline',
                    'description' => 'Last day to add or drop courses',
                    'start_date' => date('Y-m-d', strtotime($fallTerm->start_date . ' +14 days')),
                    'end_date' => date('Y-m-d', strtotime($fallTerm->start_date . ' +14 days')),
                    'event_type' => 'deadline',
                    'academic_term_id' => $fallTerm->id,
                ],
                [
                    'name' => 'Midterm Exams',
                    'description' => 'Midterm examination period',
                    'start_date' => date('Y-m-d', strtotime($fallTerm->start_date . ' +45 days')),
                    'end_date' => date('Y-m-d', strtotime($fallTerm->start_date . ' +52 days')),
                    'event_type' => 'exam',
                    'academic_term_id' => $fallTerm->id,
                ],
                [
                    'name' => 'Thanksgiving Break',
                    'description' => 'University closed for Thanksgiving holiday',
                    'start_date' => date('Y-m-d', strtotime($fallTerm->start_date . ' +85 days')),
                    'end_date' => date('Y-m-d', strtotime($fallTerm->start_date . ' +89 days')),
                    'event_type' => 'holiday',
                    'academic_term_id' => $fallTerm->id,
                ],
                [
                    'name' => 'Final Exams',
                    'description' => 'Final examination period',
                    'start_date' => date('Y-m-d', strtotime($fallTerm->end_date . ' -14 days')),
                    'end_date' => $fallTerm->end_date,
                    'event_type' => 'exam',
                    'academic_term_id' => $fallTerm->id,
                ],
            ];
            
            foreach ($events as $eventData) {
                AcademicCalendar::firstOrCreate(
                    [
                        'name' => $eventData['name'],
                        'start_date' => $eventData['start_date'],
                        'academic_term_id' => $eventData['academic_term_id']
                    ],
                    $eventData
                );
            }
        }
        
        // Create programs
        $programs = [
            [
                'name' => 'Bachelor of Science in Computer Science',
                'code' => 'BSCS',
                'description' => 'A comprehensive program covering algorithms, programming languages, software engineering, and computer systems.',
                'degree_level' => 'bachelors',
                'credits_required' => 120,
                'department_id' => $scienceDept->id,
                'duration_years' => 4,
                'status' => 'active',
            ],
            [
                'name' => 'Master of Business Administration',
                'code' => 'MBA',
                'description' => 'Advanced business administration program for future business leaders and entrepreneurs.',
                'degree_level' => 'masters',
                'credits_required' => 60,
                'department_id' => $businessDept->id,
                'duration_years' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'Bachelor of Engineering in Mechanical Engineering',
                'code' => 'BEME',
                'description' => 'Study of mechanical systems, thermodynamics, and materials science.',
                'degree_level' => 'bachelors',
                'credits_required' => 128,
                'department_id' => $engineeringDept->id,
                'duration_years' => 4,
                'status' => 'active',
            ],
        ];
        
        foreach ($programs as $programData) {
            Program::firstOrCreate(
                ['code' => $programData['code']],
                $programData
            );
        }
        
        // Create some basic courses for each program
        $bscsProgram = Program::where('code', 'BSCS')->first();
        if ($bscsProgram) {
            $csCoursesData = [
                [
                    'code' => 'CS101',
                    'name' => 'Introduction to Computer Science',
                    'description' => 'Fundamental concepts of computer science and programming',
                    'credits' => 3,
                    'department_id' => $scienceDept->id,
                    'program_id' => $bscsProgram->id,
                ],
                [
                    'code' => 'CS201',
                    'name' => 'Data Structures and Algorithms',
                    'description' => 'Study of data structures, algorithms, and their analysis',
                    'credits' => 4,
                    'department_id' => $scienceDept->id,
                    'program_id' => $bscsProgram->id,
                ],
                [
                    'code' => 'CS301',
                    'name' => 'Database Systems',
                    'description' => 'Fundamentals of database design, implementation, and management',
                    'credits' => 3,
                    'department_id' => $scienceDept->id,
                    'program_id' => $bscsProgram->id,
                ],
            ];
            
            foreach ($csCoursesData as $courseData) {
                Course::firstOrCreate(
                    ['code' => $courseData['code']],
                    $courseData
                );
            }
        }
    }
}
