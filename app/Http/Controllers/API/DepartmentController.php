<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     *
     * @param  \Illuminate\Http\Request  $request
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
        
        return response()->json([
            'success' => true,
            'data' => $departments,
        ]);
    }

    /**
     * Store a newly created department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code',
            'description' => 'nullable|string',
            'faculty_id' => 'required|exists:faculties,id',
            'head_of_department' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $department = Department::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully',
            'data' => $department,
        ], 201);
    }

    /**
     * Display the specified department.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $department->load(['faculty', 'courses', 'faculty_members']);
        
        return response()->json([
            'success' => true,
            'data' => $department,
        ]);
    }

    /**
     * Update the specified department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'faculty_id' => 'required|exists:faculties,id',
            'head_of_department' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $department->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully',
            'data' => $department,
        ]);
    }

    /**
     * Remove the specified department from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        // Check if department has any courses or students
        if ($department->courses()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete department with associated courses',
            ], 422);
        }

        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully',
        ]);
    }

    /**
     * Get all courses for a department.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function courses(Department $department)
    {
        $courses = $department->courses()->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $courses,
        ]);
    }

    /**
     * Get all faculty members for a department.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function faculty(Department $department)
    {
        $faculty = $department->faculty_members()->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $faculty,
        ]);
    }

    /**
     * Get all departments for a faculty.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function facultyDepartments(Faculty $faculty)
    {
        $departments = $faculty->departments()->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $departments,
        ]);
    }

    /**
     * Get all faculties for department selection.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFaculties()
    {
        $faculties = Faculty::select('id', 'name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $faculties,
        ]);
    }
}
