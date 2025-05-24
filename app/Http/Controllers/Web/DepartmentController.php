<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Department::with(['faculty']);
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by faculty
        if ($request->has('faculty_id') && !empty($request->faculty_id)) {
            $query->where('faculty_id', $request->faculty_id);
        }
        
        $departments = $query->paginate(10);
        $faculties = Faculty::all();
        
        return view('departments.index', compact('departments', 'faculties'));
    }

    /**
     * Show the form for creating a new department.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faculties = Faculty::all();
        $potentialHeads = User::whereHas('roles', function($query) {
            $query->where('name', 'faculty');
        })->get();
        
        return view('departments.create', compact('faculties', 'potentialHeads'));
    }

    /**
     * Store a newly created department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments',
            'description' => 'nullable|string',
            'faculty_id' => 'required|exists:faculties,id',
            'head_of_department' => 'nullable|exists:users,id',
        ]);

        $department = Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::with(['faculty', 'courses', 'students'])
            ->findOrFail($id);
            
        // Get the department head details if set
        $departmentHead = null;
        if ($department->head_of_department) {
            $departmentHead = User::find($department->head_of_department);
        }
        
        // Get counts and stats
        $courseCount = $department->courses->count();
        $studentCount = $department->students->count();
        $facultyMembers = User::whereHas('roles', function($query) {
            $query->where('name', 'faculty');
        })->where('department_id', $id)->get();
        
        return view('departments.show', compact(
            'department', 
            'departmentHead', 
            'courseCount', 
            'studentCount', 
            'facultyMembers'
        ));
    }

    /**
     * Show the form for editing the specified department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $faculties = Faculty::all();
        $potentialHeads = User::whereHas('roles', function($query) {
            $query->where('name', 'faculty');
        })->get();
        
        return view('departments.edit', compact('department', 'faculties', 'potentialHeads'));
    }

    /**
     * Update the specified department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code,' . $id,
            'description' => 'nullable|string',
            'faculty_id' => 'required|exists:faculties,id',
            'head_of_department' => 'nullable|exists:users,id',
        ]);

        $department->update($validated);

        return redirect()->route('departments.show', $department->id)
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified department from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        
        // Check if department has courses or students
        if ($department->courses()->count() > 0 || $department->students()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department with associated courses or students.');
        }
        
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
    
    /**
     * Display the courses offered by this department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function courses($id)
    {
        $department = Department::with(['courses' => function($query) {
            $query->with('professor');
        }])->findOrFail($id);
        
        return view('departments.courses', compact('department'));
    }
    
    /**
     * Display the faculty members in this department.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function faculty($id)
    {
        $department = Department::findOrFail($id);
        
        $facultyMembers = User::whereHas('roles', function($query) {
            $query->where('name', 'faculty');
        })->where('department_id', $id)->get();
        
        return view('departments.faculty', compact('department', 'facultyMembers'));
    }
    
    /**
     * Display the staff members in the department head's department.
     * This is for department heads to manage their staff.
     * 
     * @return \Illuminate\Http\Response
     */
    public function staff()
    {
        $user = Auth::user();
        
        // Get department where the user is head
        $department = Department::where('head_of_department', $user->id)->firstOrFail();
        
        // Get all staff members in the department
        $staffMembers = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['professor', 'faculty', 'staff']);
        })->where('department_id', $department->id)->paginate(15);
        
        return view('department.staff', compact('department', 'staffMembers'));
    }
    
    /**
     * Display the courses in the department head's department.
     * This is for department heads to manage their courses.
     * 
     * @return \Illuminate\Http\Response
     */
    public function courses()
    {
        $user = Auth::user();
        
        // Get department where the user is head
        $department = Department::where('head_of_department', $user->id)->firstOrFail();
        
        // Get all courses in the department
        $courses = Course::where('department_id', $department->id)
            ->with('professor')
            ->paginate(15);
        
        return view('department.courses', compact('department', 'courses'));
    }
    
    /**
     * Display statistics for the department head's department.
     * 
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        $user = Auth::user();
        
        // Get department where the user is head
        $department = Department::where('head_of_department', $user->id)->firstOrFail();
        
        // Get counts and stats
        $coursesCount = Course::where('department_id', $department->id)->count();
        $staffCount = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['professor', 'faculty', 'staff']);
        })->where('department_id', $department->id)->count();
        $studentsCount = User::whereHas('roles', function($query) {
            $query->where('name', 'student');
        })->where('department_id', $department->id)->count();
        
        // You can add more statistics as needed
        
        return view('department.statistics', compact('department', 'coursesCount', 'staffCount', 'studentsCount'));
    }
}
