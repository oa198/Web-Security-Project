<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all courses
        $rawCourses = Course::with(['professor', 'students'])->get();
        
        // Format courses for the view
        $courses = [];
        foreach ($rawCourses as $course) {
            // Check if current user is enrolled in this course
            $isEnrolled = $user->enrolledCourses->contains($course->id);
            
            // Get professor name
            $professorName = '';
            if (is_object($course->professor) && method_exists($course->professor, 'count') && $course->professor->count() > 0) {
                $professorName = $course->professor->first()->name;
            } elseif (is_string($course->professor)) {
                $professorName = $course->professor;
            }
            
            // Format schedule (if available)
            $scheduleData = [];
            if ($course->schedule) {
                // Parse schedule string or use default format
                // Example format: "Mon,Wed 10:00 AM - 11:30 AM Room 305"
                $parts = explode(' ', $course->schedule);
                if (count($parts) >= 5) {
                    $days = explode(',', $parts[0]);
                    $startTime = $parts[1] . ' ' . $parts[2]; // e.g., "10:00 AM"
                    $endTime = $parts[4] . ' ' . $parts[5];   // e.g., "11:30 AM"
                    $location = isset($parts[6]) ? implode(' ', array_slice($parts, 6)) : $course->location ?? 'TBA';
                    
                    $scheduleData = [
                        'days' => $days,
                        'startTime' => $startTime,
                        'endTime' => $endTime,
                        'location' => $location
                    ];
                } else {
                    // If schedule string doesn't match expected format
                    $scheduleData = [
                        'days' => ['TBA'],
                        'startTime' => 'TBA',
                        'endTime' => 'TBA',
                        'location' => $course->location ?? 'TBA'
                    ];
                }
            } else {
                // Default schedule if none is set
                $scheduleData = [
                    'days' => ['TBA'],
                    'startTime' => 'TBA',
                    'endTime' => 'TBA',
                    'location' => $course->location ?? 'TBA'
                ];
            }
            
            // Add course to formatted array
            $courses[] = [
                'id' => $course->id,
                'name' => $course->name ?? $course->title,
                'code' => $course->code,
                'section_id' => $course->section_id,
                'enrolled' => $isEnrolled,
                'instructor' => $professorName,
                'credits' => $course->credits,
                'schedule' => $scheduleData
            ];
        }
        
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        // Get all users who can be professors (you can modify this based on your needs)
        $professors = User::all();
        return view('courses.create', compact('professors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:courses',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1',
            'professor_id' => 'nullable|exists:users,id',
        ]);

        $course = Course::create($validated);

        // If a professor is assigned, create the relationship
        if ($request->professor_id) {
            $course->professor()->attach($request->professor_id, ['role_type' => 'professor']);
        }

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show($id)
    {
        $course = Course::with(['professor', 'students', 'grades'])->findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $professors = User::all();
        return view('courses.edit', compact('course', 'professors'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:courses,code,' . $id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1',
            'professor_id' => 'nullable|exists:users,id',
        ]);

        $course->update($validated);

        // Update professor relationship
        if ($request->professor_id) {
            $course->professor()->sync([$request->professor_id => ['role_type' => 'professor']]);
        } else {
            $course->professor()->detach();
        }

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        
        // Detach all relationships before deleting
        $course->professor()->detach();
        $course->students()->detach();
        
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function students($id)
    {
        $course = Course::with(['students' => function($query) {
            $query->with('grades');
        }])->findOrFail($id);
        
        return view('courses.students', compact('course'));
    }

    public function grades($id)
    {
        $course = Course::with(['students' => function($query) {
            $query->with(['grades' => function($query) {
                $query->where('course_id', $id);
            }]);
        }])->findOrFail($id);
        
        return view('courses.grades', compact('course'));
    }

    public function schedule($id)
    {
        $course = Course::findOrFail($id);
        // You can customize the data passed to the view as needed
        return view('courses.schedule', compact('course'));
    }
} 