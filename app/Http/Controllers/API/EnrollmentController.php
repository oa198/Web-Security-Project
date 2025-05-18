<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class EnrollmentController extends Controller
{
    protected $enrollmentService;

    /**
     * Constructor with dependency injection
     */
    public function __construct(EnrollmentService $enrollmentService)
    {   
        $this->enrollmentService = $enrollmentService;
        $this->middleware('auth');
        $this->middleware('permission:view-enrollment')->only(['index', 'show', 'getStudentSchedule', 'getSectionEnrollments', 'getSectionWaitlist']);
        $this->middleware('permission:register-course')->only(['register', 'drop']);
    }

    /**
     * Get enrollments for a student with filtering and pagination.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'status' => 'nullable|string|in:active,waitlisted,completed,dropped',
            'semester' => 'nullable|string',
            'academic_year' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
        ]);
        
        $filters = $request->only([
            'status',
            'semester',
            'academic_year',
            'course_id',
        ]);
        
        $perPage = $request->input('per_page', 15);
        $studentId = $request->input('student_id');
        
        $enrollments = $this->enrollmentService->getStudentEnrollments($studentId, $filters, $perPage);
        
        return response()->json([
            'success' => true,
            'data' => $enrollments,
            'message' => 'Enrollments retrieved successfully'
        ]);
    }

    /**
     * Register a student for a course section.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'section_id' => 'required|exists:sections,id',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
        ]);
        
        try {
            $enrollment = $this->enrollmentService->registerForSection(
                $request->input('student_id'),
                $request->input('section_id'),
                $request->input('semester'),
                $request->input('academic_year')
            );
            
            return response()->json([
                'success' => true,
                'data' => $enrollment,
                'message' => 'Registration successful'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get details of a specific enrollment.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $enrollment = $this->enrollmentService->getEnrollmentById($id);
        
        return response()->json([
            'success' => true,
            'data' => $enrollment,
            'message' => 'Enrollment retrieved successfully'
        ]);
    }

    /**
     * Drop a course for a student.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function drop(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);
        
        try {
            $result = $this->enrollmentService->dropCourse($id, $request->input('reason'));
            
            return response()->json([
                'success' => true,
                'message' => 'Course dropped successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get a student's current schedule.
     *
     * @param int $studentId
     * @param Request $request
     * @return JsonResponse
     */
    public function getStudentSchedule(int $studentId, Request $request): JsonResponse
    {
        $semester = $request->input('semester');
        $academicYear = $request->input('academic_year');
        
        $schedule = $this->enrollmentService->getStudentSchedule($studentId, $semester, $academicYear);
        
        return response()->json([
            'success' => true,
            'data' => $schedule,
            'message' => 'Student schedule retrieved successfully'
        ]);
    }

    /**
     * Get students enrolled in a specific section.
     *
     * @param int $sectionId
     * @return JsonResponse
     */
    public function getSectionEnrollments(int $sectionId): JsonResponse
    {
        $enrollments = $this->enrollmentService->getSectionEnrollments($sectionId);
        
        return response()->json([
            'success' => true,
            'data' => $enrollments,
            'message' => 'Section enrollments retrieved successfully'
        ]);
    }

    /**
     * Get waitlisted students for a specific section.
     *
     * @param int $sectionId
     * @return JsonResponse
     */
    public function getSectionWaitlist(int $sectionId): JsonResponse
    {
        $waitlist = $this->enrollmentService->getSectionWaitlist($sectionId);
        
        return response()->json([
            'success' => true,
            'data' => $waitlist,
            'message' => 'Section waitlist retrieved successfully'
        ]);
    }
    
    /**
     * Check for schedule conflicts before registration.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkScheduleConflicts(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'section_id' => 'required|exists:sections,id',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
        ]);
        
        try {
            $conflicts = $this->enrollmentService->checkScheduleConflicts(
                $request->input('student_id'),
                $request->input('section_id'),
                $request->input('semester'),
                $request->input('academic_year')
            );
            
            return response()->json([
                'success' => true,
                'data' => [
                    'has_conflicts' => count($conflicts) > 0,
                    'conflicts' => $conflicts
                ],
                'message' => count($conflicts) > 0 ? 'Schedule conflicts found' : 'No schedule conflicts'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
