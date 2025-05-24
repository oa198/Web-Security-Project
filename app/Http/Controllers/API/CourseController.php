<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    protected $courseService;

    /**
     * Constructor with dependency injection
     */
    public function __construct(CourseService $courseService)
    {   
        $this->courseService = $courseService;
    }

    /**
     * Display a paginated listing of courses.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'department_id',
            'semester',
            'academic_year',
            'instructor_id',
            'level',
            'search',
            'show_inactive'
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $courses = $this->courseService->getAllCourses($filters, $perPage);
        
        return response()->json([
            'success' => true,
            'data' => $courses,
            'message' => 'Courses retrieved successfully'
        ]);
    }

    /**
     * Store a newly created course.
     *
     * @param CourseRequest $request
     * @return JsonResponse
     */
    public function store(CourseRequest $request): JsonResponse
    {
        $course = $this->courseService->createCourse($request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $course,
            'message' => 'Course created successfully'
        ], 201);
    }

    /**
     * Display the specified course with its sections and prerequisites.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $course = $this->courseService->getCourseById($id);
        
        return response()->json([
            'success' => true,
            'data' => $course,
            'message' => 'Course retrieved successfully'
        ]);
    }

    /**
     * Update the specified course.
     *
     * @param CourseRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(CourseRequest $request, int $id): JsonResponse
    {
        $course = $this->courseService->updateCourse($id, $request->validated());
        
        return response()->json([
            'success' => true,
            'data' => $course,
            'message' => 'Course updated successfully'
        ]);
    }

    /**
     * Remove the specified course.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->courseService->deleteCourse($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }
    
    /**
     * Get all departments for course filtering.
     *
     * @return JsonResponse
     */
    public function getDepartments(): JsonResponse
    {
        $departments = $this->courseService->getAllDepartments();
        
        return response()->json([
            'success' => true,
            'data' => $departments,
            'message' => 'Departments retrieved successfully'
        ]);
    }
    
    /**
     * Get sections for a specific course.
     *
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     */
    public function getCourseSections(int $courseId, Request $request): JsonResponse
    {
        $semester = $request->input('semester');
        $academicYear = $request->input('academic_year');
        
        $sections = $this->courseService->getCourseSections($courseId, $semester, $academicYear);
        
        return response()->json([
            'success' => true,
            'data' => $sections,
            'message' => 'Course sections retrieved successfully'
        ]);
    }
    
    /**
     * Get prerequisites for a specific course.
     *
     * @param int $courseId
     * @return JsonResponse
     */
    public function getCoursePrerequisites(int $courseId): JsonResponse
    {
        $prerequisites = $this->courseService->getCoursePrerequisites($courseId);
        
        return response()->json([
            'success' => true,
            'data' => $prerequisites,
            'message' => 'Course prerequisites retrieved successfully'
        ]);
    }
    
    /**
     * Get available sections (with open seats) for a course.
     *
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     */
    public function getAvailableSections(int $courseId, Request $request): JsonResponse
    {
        $semester = $request->input('semester');
        $academicYear = $request->input('academic_year');
        
        $sections = $this->courseService->getAvailableSections($courseId, $semester, $academicYear);
        
        return response()->json([
            'success' => true,
            'data' => $sections,
            'message' => 'Available sections retrieved successfully'
        ]);
    }
}
