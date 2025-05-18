<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get courses from database
        $currentSemester = 'Fall 2023';
        
        $currentCourses = Course::where('semester', $currentSemester)
                               ->where('status', 'in_progress')
                               ->get();
        
        $completedCourses = Course::where('status', 'completed')->get();
        
        $semesters = Course::distinct()->pluck('semester')->toArray();
        $departments = Course::distinct()->pluck('department')->toArray();
        
        return view('courses.index', compact('currentCourses', 'completedCourses', 'currentSemester', 'semesters', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20',
            'professor' => 'required|string|max:255',
            'schedule' => 'nullable|string',
            'location' => 'nullable|string',
            'credits' => 'required|integer|min:1',
            'semester' => 'required|string',
            'department' => 'required|string',
        ]);
        
        Course::create($validated);
        
        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // For demo, return to index
        return redirect()->route('courses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // For demo, return to index
        return redirect()->route('courses.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // For demo, return to index
        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // For demo, return to index
        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource's students.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function students($id)
    {
        // For demo, return to index
        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource's grades.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function grades($id)
    {
        // For demo, return to index
        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource's schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function schedule($id)
    {
        // For demo, return to index
        return redirect()->route('courses.index');
    }

    /**
     * Filter courses based on criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        // For now, just redirect back to index
        return redirect()->route('courses.index')
            ->with('info', 'Courses filtered. This is a demo feature.');
    }

    /**
     * Search for courses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // For now, just redirect back to index
        return redirect()->route('courses.index')
            ->with('info', 'Course search performed. This is a demo feature.');
    }

    /**
     * Display completed courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
        // For now, just redirect back to index
        return redirect()->route('courses.index')
            ->with('info', 'Viewing all completed courses. This is a demo feature.');
    }
} 