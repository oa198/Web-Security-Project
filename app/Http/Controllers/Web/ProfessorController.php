<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class ProfessorController extends Controller
{
    public function index()
    {
        return view('web.professors.index');
    }

    public function create()
    {
        return view('web.professors.create');
    }

    public function store(Request $request)
    {
        // Store professor logic
        return redirect()->route('web.professors.index')->with('success', 'Professor created successfully');
    }

    public function show($id)
    {
        return view('web.professors.show', compact('id'));
    }

    public function edit($id)
    {
        return view('web.professors.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Update professor logic
        return redirect()->route('web.professors.index')->with('success', 'Professor updated successfully');
    }

    public function destroy($id)
    {
        // Delete professor logic
        return redirect()->route('web.professors.index')->with('success', 'Professor deleted successfully');
    }
    
    /**
     * Display the courses taught by the professor.
     *
     * @return \Illuminate\Http\Response
     */
    public function courses()
    {
        $user = Auth::user();
        
        // Get courses taught by this professor
        $courses = Course::where('professor_id', $user->id)
            ->with(['department', 'sections'])
            ->paginate(15);
            
        return view('professor.courses', compact('courses'));
    }
    
    /**
     * Display the grade management interface for the professor.
     *
     * @return \Illuminate\Http\Response
     */
    public function grades()
    {
        $user = Auth::user();
        
        // Get courses taught by this professor
        $courses = Course::where('professor_id', $user->id)
            ->with(['sections.enrollments.student.user'])
            ->get();
            
        return view('professor.grades', compact('courses'));
    }
    
    /**
     * Display the attendance management interface for the professor.
     *
     * @return \Illuminate\Http\Response
     */
    public function attendance()
    {
        $user = Auth::user();
        
        // Get courses taught by this professor
        $courses = Course::where('professor_id', $user->id)
            ->with(['sections.enrollments.student.user'])
            ->get();
            
        return view('professor.attendance', compact('courses'));
    }
}