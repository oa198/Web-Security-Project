<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Current semester courses
        Course::create([
            'name' => 'Database Systems',
            'code' => 'CS 340',
            'professor' => 'Prof. Johnson',
            'schedule' => 'Mon/Wed/Fri 9:00 AM - 10:50 AM',
            'location' => 'SCI 102',
            'credits' => 3,
            'progress' => 65,
            'semester' => 'Fall 2023',
            'department' => 'Computer Science',
            'status' => 'in_progress'
        ]);
        
        Course::create([
            'name' => 'Web Development',
            'code' => 'CS 290',
            'professor' => 'Prof. Smith',
            'schedule' => 'Tue/Thu 1:00 PM - 2:50 PM',
            'location' => 'ENG 201',
            'credits' => 4,
            'progress' => 42,
            'semester' => 'Fall 2023',
            'department' => 'Computer Science',
            'status' => 'in_progress'
        ]);
        
        Course::create([
            'name' => 'Software Engineering',
            'code' => 'CS 361',
            'professor' => 'Prof. Davis',
            'schedule' => 'Mon/Wed 11:00 AM - 12:50 PM',
            'location' => 'ENG 305',
            'credits' => 3,
            'progress' => 78,
            'semester' => 'Fall 2023',
            'department' => 'Computer Science',
            'status' => 'in_progress'
        ]);
        
        // Completed courses
        Course::create([
            'name' => 'Introduction to Programming',
            'code' => 'CS 161',
            'professor' => 'Prof. Williams',
            'schedule' => 'Mon/Wed/Fri 10:00 AM - 11:50 AM',
            'location' => 'SCI 101',
            'credits' => 4,
            'progress' => 100,
            'semester' => 'Spring 2023',
            'department' => 'Computer Science',
            'status' => 'completed'
        ]);
        
        Course::create([
            'name' => 'Data Structures',
            'code' => 'CS 261',
            'professor' => 'Prof. Green',
            'schedule' => 'Tue/Thu 9:00 AM - 10:50 AM',
            'location' => 'ENG 202',
            'credits' => 4,
            'progress' => 100,
            'semester' => 'Spring 2023',
            'department' => 'Computer Science',
            'status' => 'completed'
        ]);
        
        Course::create([
            'name' => 'Computer Architecture',
            'code' => 'CS 271',
            'professor' => 'Prof. White',
            'schedule' => 'Tue/Thu 1:00 PM - 2:20 PM',
            'location' => 'ENG 101',
            'credits' => 3,
            'progress' => 100,
            'semester' => 'Fall 2022',
            'department' => 'Computer Science',
            'status' => 'completed'
        ]);
    }
} 