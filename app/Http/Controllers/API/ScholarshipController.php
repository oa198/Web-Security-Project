<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class ScholarshipController extends Controller
{
    /**
     * Constructor with middleware
     */
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('permission:view-scholarship')->only(['index', 'show', 'getEligibleStudents']);
        $this->middleware('permission:manage-scholarship')->only(['store', 'update', 'destroy', 'awardScholarship', 'revokeScholarship']);
    }

    /**
     * Display a paginated listing of scholarships.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'type',
            'amount_min',
            'amount_max',
            'status',
            'search',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $scholarships = Scholarship::query()
            ->when(isset($filters['type']), function ($query) use ($filters) {
                return $query->where('type', $filters['type']);
            })
            ->when(isset($filters['amount_min']), function ($query) use ($filters) {
                return $query->where('amount', '>=', $filters['amount_min']);
            })
            ->when(isset($filters['amount_max']), function ($query) use ($filters) {
                return $query->where('amount', '<=', $filters['amount_max']);
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                return $query->where('status', $filters['status']);
            })
            ->when(isset($filters['search']), function ($query) use ($filters) {
                return $query->where(function ($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('description', 'like', '%' . $filters['search'] . '%');
                });
            })
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $scholarships,
            'message' => 'Scholarships retrieved successfully'
        ]);
    }

    /**
     * Store a newly created scholarship.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:scholarships',
            'description' => 'required|string',
            'type' => 'required|string|in:merit,need-based,athletic,departmental,external',
            'amount' => 'required|numeric|min:0',
            'is_percentage' => 'required|boolean',
            'duration' => 'nullable|integer|min:1',
            'duration_type' => 'nullable|string|in:semesters,years',
            'minimum_gpa' => 'nullable|numeric|min:0|max:4.0',
            'eligibility_criteria' => 'required|string',
            'application_deadline' => 'nullable|date',
            'is_renewable' => 'required|boolean',
            'renewal_criteria' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
            'max_recipients' => 'nullable|integer|min:1',
        ]);
        
        try {
            $scholarship = Scholarship::create($request->all());
            
            return response()->json([
                'success' => true,
                'data' => $scholarship,
                'message' => 'Scholarship created successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified scholarship with recipients.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $scholarship = Scholarship::with('students')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $scholarship,
            'message' => 'Scholarship retrieved successfully'
        ]);
    }

    /**
     * Update the specified scholarship.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $scholarship = Scholarship::findOrFail($id);
        
        $request->validate([
            'name' => 'nullable|string|max:100|unique:scholarships,name,' . $id,
            'description' => 'nullable|string',
            'type' => 'nullable|string|in:merit,need-based,athletic,departmental,external',
            'amount' => 'nullable|numeric|min:0',
            'is_percentage' => 'nullable|boolean',
            'duration' => 'nullable|integer|min:1',
            'duration_type' => 'nullable|string|in:semesters,years',
            'minimum_gpa' => 'nullable|numeric|min:0|max:4.0',
            'eligibility_criteria' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'is_renewable' => 'nullable|boolean',
            'renewal_criteria' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
            'max_recipients' => 'nullable|integer|min:1',
        ]);
        
        try {
            $scholarship->update($request->all());
            
            return response()->json([
                'success' => true,
                'data' => $scholarship,
                'message' => 'Scholarship updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified scholarship.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $scholarship = Scholarship::findOrFail($id);
            
            // Check if there are students using this scholarship
            if ($scholarship->students()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete scholarship. Students are currently receiving this scholarship.'
                ], 400);
            }
            
            $scholarship->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Scholarship deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get students eligible for a specific scholarship.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getEligibleStudents(int $id): JsonResponse
    {
        $scholarship = Scholarship::findOrFail($id);
        
        $eligibleStudents = $scholarship->getEligibleStudents();
        
        return response()->json([
            'success' => true,
            'data' => $eligibleStudents,
            'message' => 'Eligible students retrieved successfully'
        ]);
    }

    /**
     * Award a scholarship to a student.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function awardScholarship(Request $request): JsonResponse
    {
        $request->validate([
            'scholarship_id' => 'required|exists:scholarships,id',
            'student_id' => 'required|exists:students,id',
            'amount' => 'nullable|numeric|min:0',
            'semester' => 'required|string|max:20',
            'academic_year' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);
        
        try {
            $scholarship = Scholarship::findOrFail($request->input('scholarship_id'));
            $student = Student::findOrFail($request->input('student_id'));
            
            // Check if student is eligible
            if (!$scholarship->isStudentEligible($student->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student is not eligible for this scholarship'
                ], 400);
            }
            
            // Award the scholarship
            $amount = $request->input('amount', $scholarship->amount);
            $result = $scholarship->awardToStudent(
                $student->id, 
                $amount, 
                $request->input('semester'), 
                $request->input('academic_year'),
                $request->input('notes')
            );
            
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Scholarship awarded successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Revoke a scholarship from a student.
     *
     * @param int $studentId
     * @param int $scholarshipId
     * @param Request $request
     * @return JsonResponse
     */
    public function revokeScholarship(int $studentId, int $scholarshipId, Request $request): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);
        
        try {
            $scholarship = Scholarship::findOrFail($scholarshipId);
            $student = Student::findOrFail($studentId);
            
            $result = $scholarship->revokeFromStudent($studentId, $request->input('reason'));
            
            return response()->json([
                'success' => true,
                'message' => 'Scholarship revoked successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
