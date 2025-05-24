<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $schedules = [];
        
        if ($user->hasRole('student')) {
            // Get courses for student
            $schedules = $user->student->enrollments()
                ->with(['section.course', 'section.schedule'])
                ->get()
                ->pluck('section.schedule')
                ->filter();
        } elseif ($user->hasRole('faculty')) {
            // Get courses taught by faculty
            $schedules = Course::where('professor_id', $user->id)
                ->with('schedule')
                ->get()
                ->pluck('schedule')
                ->filter();
        }
        
        return view('schedule.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();
        return view('schedule.create', compact('courses'));
    }

    /**
     * Store a newly created schedule in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedule.index')
            ->with('success', 'Schedule created successfully.');
    }

    /**
     * Display the specified schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = Schedule::with('course')->findOrFail($id);
        return view('schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $courses = Course::all();
        return view('schedule.edit', compact('schedule', 'courses'));
    }

    /**
     * Update the specified schedule in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedule.show', $schedule->id)
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedule.index')
            ->with('success', 'Schedule deleted successfully.');
    }
    
    /**
     * Display a calendar view of schedules.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        $user = Auth::user();
        $schedules = [];
        
        if ($user->hasRole('student')) {
            // Get courses for student
            $schedules = $user->student->enrollments()
                ->with(['section.course', 'section.schedule'])
                ->get()
                ->pluck('section.schedule')
                ->filter();
        } elseif ($user->hasRole('faculty')) {
            // Get courses taught by faculty
            $schedules = Course::where('professor_id', $user->id)
                ->with('schedule')
                ->get()
                ->pluck('schedule')
                ->filter();
        } else {
            // For admin, show all schedules
            $schedules = Schedule::with('course')->get();
        }
        
        // Format for calendar view
        $calendarEvents = $schedules->map(function($schedule) {
            return [
                'title' => $schedule->course->name ?? 'Untitled Course',
                'day' => $schedule->day_of_week,
                'start' => $schedule->start_time,
                'end' => $schedule->end_time,
                'location' => $schedule->location,
                'url' => route('schedule.show', $schedule->id)
            ];
        });
        
        return view('schedule.calendar', compact('calendarEvents'));
    }
}
