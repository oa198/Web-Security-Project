<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // In a real app, we would fetch data from the database
        // For now, we'll use dummy data
        
        // Quick stats
        $stats = [
            'gpa' => 3.85,
            'courses_count' => 5,
            'due_soon_count' => 7,
            'completed_count' => 24
        ];
        
        // Upcoming assignments
        $upcomingAssignments = [
            [
                'id' => 1,
                'title' => 'Web Development Quiz',
                'course' => 'Web Development',
                'instructor' => 'Prof. Smith',
                'due_date' => 'today',
                'due_time' => '11:59 PM',
                'status' => 'due_today'
            ],
            [
                'id' => 2,
                'title' => 'Software Engineering SCRUM Report',
                'course' => 'Software Engineering',
                'instructor' => 'Prof. Davis',
                'due_date' => 'today',
                'due_time' => '11:59 PM',
                'status' => 'due_today'
            ],
            [
                'id' => 3,
                'title' => 'SQL Challenge',
                'course' => 'Database Systems',
                'instructor' => 'Prof. Johnson',
                'due_date' => 'in 2 days',
                'due_time' => 'May 19, 2023',
                'status' => 'upcoming'
            ],
            [
                'id' => 4,
                'title' => 'JavaScript Framework Comparison',
                'course' => 'Web Development',
                'instructor' => 'Prof. Smith',
                'due_date' => 'in 4 days',
                'due_time' => 'May 21, 2023',
                'status' => 'upcoming'
            ]
        ];
        
        // Course overview
        $courseOverview = [
            [
                'name' => 'Database Systems',
                'grade' => 'A',
                'percentage' => 95
            ],
            [
                'name' => 'Web Development',
                'grade' => 'A-',
                'percentage' => 91
            ],
            [
                'name' => 'Computer Networks',
                'grade' => 'B+',
                'percentage' => 88
            ],
            [
                'name' => 'Software Engineering',
                'grade' => 'A',
                'percentage' => 93
            ],
            [
                'name' => 'Data Science',
                'grade' => 'B',
                'percentage' => 85
            ]
        ];
        
        // Today's schedule
        $todaySchedule = [
            [
                'name' => 'Database Systems',
                'start_time' => '9:00 AM',
                'end_time' => '10:50 AM',
                'instructor' => 'Prof. Johnson',
                'location' => 'SCI 102',
                'type' => 'Lecture'
            ],
            [
                'name' => 'Software Engineering',
                'start_time' => '11:00 AM',
                'end_time' => '12:20 PM',
                'instructor' => 'Prof. Davis',
                'location' => 'ENG 305',
                'type' => 'Lecture'
            ],
            [
                'name' => 'Web Development',
                'start_time' => '2:00 PM',
                'end_time' => '3:50 PM',
                'instructor' => 'Prof. Smith',
                'location' => 'COMP 201',
                'type' => 'Lab'
            ]
        ];
        
        // Recent notifications
        $recentNotifications = [
            [
                'id' => 1,
                'title' => 'Database Final Project Posted',
                'content' => 'The final project for Database Systems has been posted. Due May 30.',
                'time' => '2 hours ago',
                'type' => 'info'
            ],
            [
                'id' => 2,
                'title' => 'Quiz Grade Posted',
                'content' => 'Your Web Development Quiz 3 has been graded. Score: 92%',
                'time' => 'Yesterday',
                'type' => 'success'
            ],
            [
                'id' => 3,
                'title' => 'Class Canceled',
                'content' => 'Computer Networks class on Friday, May 19 has been canceled.',
                'time' => '2 days ago',
                'type' => 'warning'
            ]
        ];

        return view('dashboard', compact(
            'stats', 
            'upcomingAssignments', 
            'courseOverview', 
            'todaySchedule', 
            'recentNotifications'
        ));
    }

    /**
     * View all assignments from the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAllAssignments()
    {
        return redirect()->route('assignments.index');
    }

    /**
     * View all courses from the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAllCourses()
    {
        return redirect()->route('courses.index');
    }

    /**
     * View full schedule from the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewFullSchedule()
    {
        return redirect()->route('schedule.index');
    }

    /**
     * View all notifications from the dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAllNotifications()
    {
        return redirect()->route('notifications.index');
    }
} 