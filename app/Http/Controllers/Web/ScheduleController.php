<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display the user's schedule.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // In a real app, we would fetch the schedule from the database
        // For now, we'll use dummy data
        $courses = [
            [
                'id' => 1,
                'code' => 'CS 340',
                'name' => 'Database Systems',
                'instructor' => 'Prof. Johnson',
                'days' => ['Monday', 'Wednesday', 'Friday'],
                'start_time' => '9:00 AM',
                'end_time' => '10:50 AM',
                'location' => 'SCI 102',
                'type' => 'Lecture'
            ],
            [
                'id' => 2,
                'code' => 'CS 361',
                'name' => 'Software Engineering',
                'instructor' => 'Prof. Davis',
                'days' => ['Tuesday', 'Thursday'],
                'start_time' => '11:00 AM',
                'end_time' => '12:20 PM',
                'location' => 'ENG 305',
                'type' => 'Lecture'
            ],
            [
                'id' => 3,
                'code' => 'CS 290',
                'name' => 'Web Development',
                'instructor' => 'Prof. Smith',
                'days' => ['Wednesday', 'Friday'],
                'start_time' => '2:00 PM',
                'end_time' => '3:50 PM',
                'location' => 'COMP 201',
                'type' => 'Lab'
            ]
        ];

        $currentWeek = [
            'start_date' => now()->startOfWeek()->format('M d'),
            'end_date' => now()->endOfWeek()->format('M d, Y')
        ];

        $currentTerm = 'Spring 2023';

        return view('schedule', compact('courses', 'currentWeek', 'currentTerm'));
    }

    /**
     * Display schedule for a specific term.
     *
     * @param  string  $term
     * @return \Illuminate\Http\Response
     */
    public function term($term)
    {
        // In a real app, we would fetch the schedule based on term
        // For now, we'll just redirect back with a notification
        
        return redirect()->route('schedule.index')->with('info', 'Displaying schedule for ' . $term);
    }

    /**
     * Change the view mode (week, month, list).
     *
     * @param  string  $view
     * @return \Illuminate\Http\Response
     */
    public function changeView($view)
    {
        // In a real app, we would change the view mode
        // For now, we'll just redirect back with a notification
        
        return redirect()->route('schedule.index')->with('info', 'Changed view to ' . $view);
    }

    /**
     * Navigate to a specific date in the schedule.
     *
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function navigate($date)
    {
        // In a real app, we would navigate to the specific date
        // For now, we'll just redirect back with a notification
        
        return redirect()->route('schedule.index')->with('info', 'Navigated to ' . $date);
    }
} 