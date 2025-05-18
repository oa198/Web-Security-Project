<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamsController extends Controller
{
    /**
     * Display a listing of exams.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // In a real application, this would fetch from database
        // This is dummy data for demonstration purposes
        
        $upcomingExams = [
            [
                'id' => 1,
                'course_name' => 'Database Systems',
                'course_code' => 'CS3200',
                'title' => 'Midterm Exam',
                'date' => now()->addDays(5)->format('Y-m-d'),
                'time' => '14:00:00',
                'duration' => 120, // minutes
                'location' => 'Room 305, Building A',
                'format' => 'In-person',
                'status' => 'upcoming'
            ],
            [
                'id' => 2,
                'course_name' => 'Web Development',
                'course_code' => 'CS4550',
                'title' => 'Final Project Presentation',
                'date' => now()->addDays(12)->format('Y-m-d'),
                'time' => '10:00:00',
                'duration' => 30, // minutes
                'location' => 'Online (Zoom)',
                'format' => 'Virtual',
                'status' => 'upcoming'
            ],
            [
                'id' => 3,
                'course_name' => 'Computer Networks',
                'course_code' => 'CS3700',
                'title' => 'Final Exam',
                'date' => now()->addDays(15)->format('Y-m-d'),
                'time' => '09:00:00',
                'duration' => 180, // minutes
                'location' => 'Exam Hall 2',
                'format' => 'In-person',
                'status' => 'upcoming'
            ],
        ];
        
        $pastExams = [
            [
                'id' => 4,
                'course_name' => 'Database Systems',
                'course_code' => 'CS3200',
                'title' => 'Quiz 2',
                'date' => now()->subDays(10)->format('Y-m-d'),
                'time' => '14:00:00',
                'duration' => 45, // minutes
                'location' => 'Room 305, Building A',
                'format' => 'In-person',
                'status' => 'completed',
                'score' => 92,
                'total' => 100,
                'feedback_available' => true
            ],
            [
                'id' => 5,
                'course_name' => 'Web Development',
                'course_code' => 'CS4550',
                'title' => 'Midterm Exam',
                'date' => now()->subDays(20)->format('Y-m-d'),
                'time' => '13:30:00',
                'duration' => 120, // minutes
                'location' => 'Room 202, Building B',
                'format' => 'In-person',
                'status' => 'completed',
                'score' => 85,
                'total' => 100,
                'feedback_available' => true
            ],
            [
                'id' => 6,
                'course_name' => 'Software Engineering',
                'course_code' => 'CS4500',
                'title' => 'Project Defense',
                'date' => now()->subDays(5)->format('Y-m-d'),
                'time' => '11:00:00',
                'duration' => 45, // minutes
                'location' => 'Online (Teams)',
                'format' => 'Virtual',
                'status' => 'completed',
                'score' => 89,
                'total' => 100,
                'feedback_available' => false
            ],
        ];
        
        // Count exams in different categories
        $upcomingCount = count($upcomingExams);
        $completedCount = count($pastExams);
        $totalCount = $upcomingCount + $completedCount;
        
        return view('exams.index', compact(
            'upcomingExams',
            'pastExams',
            'upcomingCount',
            'completedCount',
            'totalCount'
        ));
    }
    
    /**
     * Display the specified exam details.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // In a real application, this would fetch from database
        // This is dummy data for demonstration purposes
        
        $exam = [
            'id' => $id,
            'course_name' => 'Database Systems',
            'course_code' => 'CS3200',
            'title' => 'Midterm Exam',
            'description' => 'Comprehensive exam covering relational algebra, SQL, normalization, and transaction processing.',
            'date' => now()->addDays(5)->format('Y-m-d'),
            'time' => '14:00:00',
            'end_time' => '16:00:00',
            'duration' => 120, // minutes
            'location' => 'Room 305, Building A',
            'format' => 'In-person',
            'status' => 'upcoming',
            'instructions' => [
                'Bring your student ID card',
                'No electronic devices allowed except for non-programmable calculators',
                'Arrive 15 minutes before the exam starts',
                'Ensure you have blue or black pens'
            ],
            'materials' => [
                [
                    'name' => 'Study Guide',
                    'type' => 'pdf',
                    'size' => '1.2 MB'
                ],
                [
                    'name' => 'Practice Questions',
                    'type' => 'pdf',
                    'size' => '890 KB'
                ],
                [
                    'name' => 'Formula Sheet (allowed during exam)',
                    'type' => 'pdf',
                    'size' => '450 KB'
                ]
            ]
        ];
        
        return view('exams.show', compact('exam'));
    }
    
    /**
     * Display the results for a completed exam.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function results($id)
    {
        // In a real application, this would fetch from database
        // This is dummy data for demonstration purposes
        
        $results = [
            'id' => $id,
            'course_name' => 'Web Development',
            'course_code' => 'CS4550',
            'title' => 'Midterm Exam',
            'date_taken' => now()->subDays(20)->format('Y-m-d'),
            'score' => 85,
            'total' => 100,
            'percentage' => 85,
            'letter_grade' => 'B',
            'status' => 'Passed',
            'sections' => [
                [
                    'name' => 'Multiple Choice',
                    'score' => 28,
                    'total' => 30,
                    'percentage' => 93
                ],
                [
                    'name' => 'Short Answer',
                    'score' => 18,
                    'total' => 20,
                    'percentage' => 90
                ],
                [
                    'name' => 'Coding Problem',
                    'score' => 39,
                    'total' => 50,
                    'percentage' => 78
                ],
            ],
            'feedback' => 'Good understanding of HTML/CSS concepts. JavaScript implementation could be improved, particularly in DOM manipulation and event handling. Review async/await and promise concepts.',
            'instructor_comments' => 'Please see me during office hours if you have questions about the coding portion of the exam.'
        ];
        
        return view('exams.results', compact('results'));
    }
    
    /**
     * Filter exams based on criteria.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function filter(Request $request)
    {
        // In a real application, this would apply filters to database query
        // Here we'll just return with a success message indicating the filter was applied
        
        return redirect()->route('exams.index')
            ->with('success', 'Exams filtered successfully.');
    }
    
    /**
     * Start exam preparation session.
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prepare($id)
    {
        // In a real application, this would start an exam preparation session
        // Here we'll just return with a success message
        
        return redirect()->route('exams.show', $id)
            ->with('success', 'Exam preparation session started.');
    }
    
    /**
     * Display calendar view of exams.
     * 
     * @return \Illuminate\View\View
     */
    public function calendar()
    {
        return view('exams.calendar');
    }
} 