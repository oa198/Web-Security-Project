<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultyController extends Controller
{
    /**
     * Display a listing of the faculties.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = Faculty::withCount('departments')
            ->paginate(10);
            
        return view('faculty.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new faculty.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deans = User::whereHas('roles', function($query) {
            $query->where('name', 'faculty');
        })->get();
        
        return view('faculty.create', compact('deans'));
    }

    /**
     * Store a newly created faculty in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:faculties',
            'description' => 'nullable|string',
            'dean_id' => 'nullable|exists:users,id',
        ]);

        $faculty = Faculty::create($validated);

        return redirect()->route('faculty.index')
            ->with('success', 'Faculty created successfully.');
    }

    /**
     * Display the specified faculty.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faculty = Faculty::with(['departments', 'dean'])
            ->withCount(['departments'])
            ->findOrFail($id);
            
        // Get department heads
        $departmentHeads = [];
        foreach ($faculty->departments as $department) {
            if ($department->head_of_department) {
                $head = User::find($department->head_of_department);
                if ($head) {
                    $departmentHeads[$department->id] = $head;
                }
            }
        }
        
        // Get faculty members count
        $facultyMembersCount = User::whereHas('roles', function($query) {
                $query->where('name', 'faculty');
            })
            ->whereIn('department_id', $faculty->departments->pluck('id'))
            ->count();
            
        // Get student count
        $studentCount = Department::whereIn('id', $faculty->departments->pluck('id'))
            ->withCount('students')
            ->get()
            ->sum('students_count');
        
        return view('faculty.show', compact(
            'faculty', 
            'departmentHeads', 
            'facultyMembersCount', 
            'studentCount'
        ));
    }

    /**
     * Show the form for editing the specified faculty.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faculty = Faculty::findOrFail($id);
        $deans = User::whereHas('roles', function($query) {
            $query->where('name', 'faculty');
        })->get();
        
        return view('faculty.edit', compact('faculty', 'deans'));
    }

    /**
     * Update the specified faculty in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $faculty = Faculty::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:faculties,code,' . $id,
            'description' => 'nullable|string',
            'dean_id' => 'nullable|exists:users,id',
        ]);

        $faculty->update($validated);

        return redirect()->route('faculty.show', $faculty->id)
            ->with('success', 'Faculty updated successfully.');
    }

    /**
     * Remove the specified faculty from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faculty = Faculty::findOrFail($id);
        
        // Check if faculty has departments
        if ($faculty->departments()->count() > 0) {
            return redirect()->route('faculty.index')
                ->with('error', 'Cannot delete faculty with associated departments.');
        }
        
        $faculty->delete();

        return redirect()->route('faculty.index')
            ->with('success', 'Faculty deleted successfully.');
    }
    
    /**
     * Display the departments in this faculty.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function departments($id)
    {
        $faculty = Faculty::findOrFail($id);
        $departments = Department::where('faculty_id', $id)
            ->withCount(['courses', 'students'])
            ->paginate(10);
        
        return view('faculty.departments', compact('faculty', 'departments'));
    }
}
