<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramRequirement;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|registrar']);
    }

    /**
     * Display a listing of programs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Program::with('department');
        
        // Filter by department if provided
        if ($request->has('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        
        // Filter by program level if provided
        if ($request->has('level')) {
            $query->where('level', $request->level);
        }
        
        // Filter by active status if provided
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }
        
        $programs = $query->orderBy('name')->paginate(10);
        $departments = Department::orderBy('name')->get();
        
        return view('admin.programs.index', compact('programs', 'departments'));
    }

    /**
     * Show the form for creating a new program.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $courses = Course::orderBy('code')->get();
        
        return view('admin.programs.create', compact('departments', 'courses'));
    }

    /**
     * Store a newly created program in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs',
            'level' => 'required|in:undergraduate,graduate,doctoral,certificate,diploma',
            'description' => 'nullable|string',
            'duration_years' => 'required|numeric|min:0.5',
            'credit_hours' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'admission_requirements' => 'nullable|string',
            'graduation_requirements' => 'nullable|string',
            'career_opportunities' => 'nullable|string',
            'tuition_fee' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Create the program
            $program = Program::create($request->all());
            
            // Handle program requirements if provided
            if ($request->has('requirements')) {
                foreach ($request->requirements as $requirementData) {
                    $requirement = new ProgramRequirement([
                        'course_id' => $requirementData['course_id'],
                        'requirement_type' => $requirementData['requirement_type'],
                        'minimum_grade' => $requirementData['minimum_grade'] ?? null,
                        'credits' => $requirementData['credits'] ?? null,
                        'year_level' => $requirementData['year_level'] ?? null,
                        'semester' => $requirementData['semester'] ?? null,
                        'notes' => $requirementData['notes'] ?? null,
                    ]);
                    
                    $program->requirements()->save($requirement);
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.programs.index')
                ->with('success', 'Program created successfully');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Error creating program: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified program.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        $program->load(['department', 'requirements.course', 'prerequisites']);
        
        // Get program statistics
        $stats = [
            'total_students' => $program->students()->count(),
            'active_students' => $program->students()->where('status', 'active')->count(),
            'graduates' => $program->students()->where('status', 'graduated')->count(),
            'requirements_count' => $program->requirements()->count(),
            'prerequisites_count' => $program->prerequisites()->count(),
        ];
        
        return view('admin.programs.show', compact('program', 'stats'));
    }

    /**
     * Show the form for editing the specified program.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        $program->load(['requirements.course', 'prerequisites']);
        $departments = Department::orderBy('name')->get();
        $courses = Course::orderBy('code')->get();
        
        return view('admin.programs.edit', compact('program', 'departments', 'courses'));
    }

    /**
     * Update the specified program in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs,code,' . $program->id,
            'level' => 'required|in:undergraduate,graduate,doctoral,certificate,diploma',
            'description' => 'nullable|string',
            'duration_years' => 'required|numeric|min:0.5',
            'credit_hours' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'admission_requirements' => 'nullable|string',
            'graduation_requirements' => 'nullable|string',
            'career_opportunities' => 'nullable|string',
            'tuition_fee' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Update the program
            $program->update($request->all());
            
            // Update program requirements if provided
            if ($request->has('requirements')) {
                // Remove existing requirements not in the updated list
                $existingIds = [];
                foreach ($request->requirements as $requirementData) {
                    if (isset($requirementData['id']) && $requirementData['id']) {
                        $existingIds[] = $requirementData['id'];
                    }
                }
                
                $program->requirements()->whereNotIn('id', $existingIds)->delete();
                
                // Update or create requirements
                foreach ($request->requirements as $requirementData) {
                    if (isset($requirementData['id']) && $requirementData['id']) {
                        // Update existing requirement
                        $requirement = ProgramRequirement::find($requirementData['id']);
                        if ($requirement) {
                            $requirement->update([
                                'course_id' => $requirementData['course_id'],
                                'requirement_type' => $requirementData['requirement_type'],
                                'minimum_grade' => $requirementData['minimum_grade'] ?? null,
                                'credits' => $requirementData['credits'] ?? null,
                                'year_level' => $requirementData['year_level'] ?? null,
                                'semester' => $requirementData['semester'] ?? null,
                                'notes' => $requirementData['notes'] ?? null,
                            ]);
                        }
                    } else {
                        // Create new requirement
                        $requirement = new ProgramRequirement([
                            'course_id' => $requirementData['course_id'],
                            'requirement_type' => $requirementData['requirement_type'],
                            'minimum_grade' => $requirementData['minimum_grade'] ?? null,
                            'credits' => $requirementData['credits'] ?? null,
                            'year_level' => $requirementData['year_level'] ?? null,
                            'semester' => $requirementData['semester'] ?? null,
                            'notes' => $requirementData['notes'] ?? null,
                        ]);
                        
                        $program->requirements()->save($requirement);
                    }
                }
            } else {
                // If no requirements provided, remove all existing
                $program->requirements()->delete();
            }
            
            DB::commit();
            
            return redirect()->route('admin.programs.index')
                ->with('success', 'Program updated successfully');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Error updating program: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified program from storage.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        // Check if program has associated students
        if ($program->students()->count() > 0) {
            return redirect()->route('admin.programs.index')
                ->with('error', 'Cannot delete program with associated students');
        }
        
        DB::beginTransaction();
        try {
            // Delete program requirements
            $program->requirements()->delete();
            
            // Delete program prerequisites
            $program->prerequisites()->delete();
            
            // Delete the program
            $program->delete();
            
            DB::commit();
            
            return redirect()->route('admin.programs.index')
                ->with('success', 'Program deleted successfully');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('admin.programs.index')
                ->with('error', 'Error deleting program: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for managing program requirements.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function manageRequirements(Program $program)
    {
        $program->load('requirements.course');
        $courses = Course::orderBy('code')->get();
        
        return view('admin.programs.manage-requirements', compact('program', 'courses'));
    }

    /**
     * Store or update program requirements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function storeRequirements(Request $request, Program $program)
    {
        $validator = Validator::make($request->all(), [
            'requirements' => 'required|array|min:1',
            'requirements.*.course_id' => 'required|exists:courses,id',
            'requirements.*.requirement_type' => 'required|in:core,elective,general,specialization',
            'requirements.*.minimum_grade' => 'nullable|string|max:2',
            'requirements.*.credits' => 'nullable|numeric|min:0',
            'requirements.*.year_level' => 'nullable|integer|min:1|max:10',
            'requirements.*.semester' => 'nullable|in:fall,spring,summer,winter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Clear existing requirements if requested
            if ($request->boolean('clear_existing', false)) {
                $program->requirements()->delete();
            }
            
            // Add new requirements
            foreach ($request->requirements as $requirementData) {
                $requirement = new ProgramRequirement([
                    'course_id' => $requirementData['course_id'],
                    'requirement_type' => $requirementData['requirement_type'],
                    'minimum_grade' => $requirementData['minimum_grade'] ?? null,
                    'credits' => $requirementData['credits'] ?? null,
                    'year_level' => $requirementData['year_level'] ?? null,
                    'semester' => $requirementData['semester'] ?? null,
                    'notes' => $requirementData['notes'] ?? null,
                ]);
                
                $program->requirements()->save($requirement);
            }
            
            DB::commit();
            
            return redirect()->route('admin.programs.show', $program)
                ->with('success', 'Program requirements updated successfully');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Error updating program requirements: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for managing program prerequisites.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function managePrerequisites(Program $program)
    {
        $program->load('prerequisites');
        $programs = Program::where('id', '!=', $program->id)->orderBy('name')->get();
        
        return view('admin.programs.manage-prerequisites', compact('program', 'programs'));
    }

    /**
     * Store or update program prerequisites.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function storePrerequisites(Request $request, Program $program)
    {
        $validator = Validator::make($request->all(), [
            'prerequisites' => 'required|array',
            'prerequisites.*.prerequisite_program_id' => 'required|exists:programs,id|different:program_id',
            'prerequisites.*.minimum_gpa' => 'nullable|numeric|min:0|max:4.0',
            'prerequisites.*.notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Clear existing prerequisites if requested
            if ($request->boolean('clear_existing', false)) {
                $program->prerequisites()->delete();
            }
            
            // Add new prerequisites
            foreach ($request->prerequisites as $prerequisiteData) {
                $prerequisite = new \App\Models\Prerequisite([
                    'program_id' => $program->id,
                    'prerequisite_program_id' => $prerequisiteData['prerequisite_program_id'],
                    'minimum_gpa' => $prerequisiteData['minimum_gpa'] ?? null,
                    'notes' => $prerequisiteData['notes'] ?? null,
                ]);
                
                $prerequisite->save();
            }
            
            DB::commit();
            
            return redirect()->route('admin.programs.show', $program)
                ->with('success', 'Program prerequisites updated successfully');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Error updating program prerequisites: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Export program details to PDF.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Program $program)
    {
        $program->load(['department', 'requirements.course', 'prerequisites.prerequisiteProgram']);
        
        // Implementation would depend on PDF library used
        // For example, using Laravel-DomPDF
        
        // As a placeholder:
        return redirect()->route('admin.programs.show', $program)
            ->with('info', 'PDF export functionality will be implemented soon.');
    }

    /**
     * Export program details to Excel/CSV.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(Program $program)
    {
        $program->load(['department', 'requirements.course', 'prerequisites.prerequisiteProgram']);
        
        // Implementation would depend on Excel library used
        // For example, using Laravel Excel
        
        // As a placeholder:
        return redirect()->route('admin.programs.show', $program)
            ->with('info', 'Excel export functionality will be implemented soon.');
    }

    /**
     * Import program data from Excel/CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,txt,xls,xlsx',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Implementation would depend on Excel library used
        // For example, using Laravel Excel
        
        // As a placeholder:
        return redirect()->route('admin.programs.index')
            ->with('info', 'Import functionality will be implemented soon.');
    }
}
