<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Course;

class CourseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users to be professors (just take the first 3 users)
        $users = User::take(3)->get();

        // Get all courses
        $courses = Course::all();
        if ($courses->isEmpty()) {
            // If no courses exist, create a few
            $courseData = [
                [
                    'name' => 'Introduction to Computer Science',
                    'code' => 'CS 101',
                    'description' => 'An introductory course to computer science principles.',
                    'credits' => 3,
                    'semester' => 'Fall',
                    'year' => 2023,
                ],
                [
                    'name' => 'Data Structures and Algorithms',
                    'code' => 'CS 201',
                    'description' => 'Learn about data structures and algorithm analysis.',
                    'credits' => 4,
                    'semester' => 'Spring',
                    'year' => 2023,
                ],
                [
                    'name' => 'Web Development',
                    'code' => 'CS 301',
                    'description' => 'Fundamentals of web development including HTML, CSS, and JavaScript.',
                    'credits' => 3,
                    'semester' => 'Fall',
                    'year' => 2023,
                ],
                [
                    'name' => 'Database Systems',
                    'code' => 'CS 305',
                    'description' => 'Design and implementation of database systems.',
                    'credits' => 3,
                    'semester' => 'Spring',
                    'year' => 2023,
                ],
                [
                    'name' => 'Software Engineering',
                    'code' => 'CS 401',
                    'description' => 'Principles of software engineering and project management.',
                    'credits' => 4,
                    'semester' => 'Fall',
                    'year' => 2023,
                ],
                [
                    'name' => 'Artificial Intelligence',
                    'code' => 'CS 430',
                    'description' => 'Introduction to artificial intelligence concepts and applications.',
                    'credits' => 3,
                    'semester' => 'Spring',
                    'year' => 2023,
                ],
            ];

            foreach ($courseData as $course) {
                Course::create($course);
            }
            
            // Get the newly created courses
            $courses = Course::all();
        }

        // Assign professors to courses
        foreach ($courses as $index => $course) {
            // Assign a professor to each course (cycling through available users)
            $professorIndex = $index % count($users);
            
            DB::table('course_user')->insert([
                'user_id' => $users[$professorIndex]->id,
                'course_id' => $course->id,
                'role_type' => 'professor',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Assign some students to each course
            $students = User::where('id', '!=', $users[$professorIndex]->id)
                          ->inRandomOrder()
                          ->take(rand(5, 15))
                          ->get();
            
            foreach ($students as $student) {
                DB::table('course_user')->insert([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'role_type' => 'student',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
} 