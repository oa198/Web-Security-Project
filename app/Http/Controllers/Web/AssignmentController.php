<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // In a real app, we would fetch assignments from the database
        // For now, we'll use dummy data
        $assignments = [
            [
                'id' => 1,
                'title' => 'Database Final Project',
                'course' => 'Database Systems',
                'instructor' => 'Prof. Johnson',
                'due_date' => now()->subDays(2),
                'status' => 'overdue',
                'priority' => 'high'
            ],
            [
                'id' => 2,
                'title' => 'Network Topology Report',
                'course' => 'Computer Networks',
                'instructor' => 'Prof. Williams',
                'due_date' => now()->subDays(1),
                'status' => 'overdue',
                'priority' => 'high'
            ],
            [
                'id' => 3,
                'title' => 'Web Development Quiz',
                'course' => 'Web Development',
                'instructor' => 'Prof. Smith',
                'due_date' => now()->endOfDay(),
                'status' => 'due_today',
                'priority' => 'medium'
            ],
            [
                'id' => 4,
                'title' => 'Software Engineering SCRUM Report',
                'course' => 'Software Engineering',
                'instructor' => 'Prof. Davis',
                'due_date' => now()->endOfDay(),
                'status' => 'due_today',
                'priority' => 'medium'
            ],
            [
                'id' => 5,
                'title' => 'Data Visualization Assignment',
                'course' => 'Data Science',
                'instructor' => 'Prof. Miller',
                'due_date' => now()->setHour(17)->setMinute(0),
                'status' => 'due_today',
                'priority' => 'medium'
            ],
            [
                'id' => 6,
                'title' => 'SQL Challenge',
                'course' => 'Database Systems',
                'instructor' => 'Prof. Johnson',
                'due_date' => now()->addDays(2),
                'status' => 'upcoming',
                'priority' => 'low'
            ],
            [
                'id' => 7,
                'title' => 'JavaScript Framework Comparison',
                'course' => 'Web Development',
                'instructor' => 'Prof. Smith',
                'due_date' => now()->addDays(4),
                'status' => 'upcoming',
                'priority' => 'medium'
            ]
        ];

        // Filter assignments by status
        $overdue = array_filter($assignments, function($assignment) {
            return $assignment['status'] == 'overdue';
        });
        
        $dueToday = array_filter($assignments, function($assignment) {
            return $assignment['status'] == 'due_today';
        });
        
        $upcoming = array_filter($assignments, function($assignment) {
            return $assignment['status'] == 'upcoming';
        });
        
        // Count assignments
        $overdueCount = count($overdue);
        $dueTodayCount = count($dueToday);
        $upcomingCount = count($upcoming);
        $completedCount = 24; // Dummy data

        return view('assignments', compact(
            'assignments', 
            'overdue', 
            'dueToday', 
            'upcoming', 
            'overdueCount', 
            'dueTodayCount', 
            'upcomingCount', 
            'completedCount'
        ));
    }

    /**
     * Display the submission form for an assignment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submit($id)
    {
        // In a real app, we would fetch the assignment and display a form
        // For now, we'll just return a success response
        
        return redirect()->back()->with('info', 'Submission form would be displayed here');
    }

    /**
     * Start an assignment (quiz, lab, etc).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function start($id)
    {
        // In a real app, we would start the assignment session
        // For now, we'll just return a success response
        
        return redirect()->back()->with('info', 'Assignment would start here');
    }

    /**
     * Filter assignments by various criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        // In a real app, we would filter based on request parameters
        // For now, we'll just return a success response
        
        return redirect()->route('assignments.index')->with('info', 'Assignments filtered');
    }
} 