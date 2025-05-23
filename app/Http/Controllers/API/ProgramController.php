<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    /**
     * Display a listing of programs.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Program::with('department');
        
        // Filter by department if provided
        if ($request->has('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        
        // Filter by degree type if provided
        if ($request->has('degree_type')) {
            $query->where('degree_type', $request->degree_type);
        }
        
        // Filter by active status if provided
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }
        
        // Search by name or code
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }
        
        $programs = $query->orderBy('name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $programs
        ]);
    }

    /**
     * Store a newly created program.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs',
            'department_id' => 'required|exists:departments,id',
            'credits_required' => 'required|integer|min:1',
            'degree_type' => 'required|in:associate,bachelor,master,doctorate,certificate,diploma',
            'duration_years' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'coordinator_name' => 'nullable|string|max:255',
            'coordinator_email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $program = Program::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Program created successfully',
            'data' => $program
        ], 201);
    }

    /**
     * Display the specified program.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $program = Program::with(['department', 'department.faculty'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $program
        ]);
    }

    /**
     * Update the specified program.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $program = Program::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'code' => 'string|max:50|unique:programs,code,' . $id,
            'department_id' => 'exists:departments,id',
            'credits_required' => 'integer|min:1',
            'degree_type' => 'in:associate,bachelor,master,doctorate,certificate,diploma',
            'duration_years' => 'integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'coordinator_name' => 'nullable|string|max:255',
            'coordinator_email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $program->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Program updated successfully',
            'data' => $program
        ]);
    }

    /**
     * Remove the specified program.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $program = Program::findOrFail($id);
        
        // Check if program has associated students
        if ($program->students()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete program with enrolled students'
            ], 409);
        }
        
        $program->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Program deleted successfully'
        ]);
    }

    /**
     * Get courses for a specific program.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function courses($id): JsonResponse
    {
        $program = Program::findOrFail($id);
        $courses = $program->courses()->with('prerequisites')->get();
        
        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    /**
     * Get requirements for a specific program.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function requirements($id): JsonResponse
    {
        $program = Program::findOrFail($id);
        $requirements = $program->requirements()->with('course')->get()
            ->groupBy('requirement_type');
        
        return response()->json([
            'success' => true,
            'data' => $requirements
        ]);
    }

    /**
     * Get students enrolled in a specific program.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function students($id): JsonResponse
    {
        $program = Program::findOrFail($id);
        $students = $program->students()->with('user')->get();
        
        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }
}
