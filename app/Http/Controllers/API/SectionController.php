<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class SectionController extends Controller
{
    protected $courseService;

    /**
     * Constructor with dependency injection
     */
    public function __construct(CourseService $courseService)
    {   
        $this->courseService = $courseService;
        $this->middleware('auth');
        $this->middleware('permission:view-section')->only(['index', 'show', 'getSectionDetails']);
        $this->middleware('permission:manage-section')->only(['store', 'update', 'destroy', 'updateCapacity']);
    }

    /**
     * Display a paginated listing of sections with filters.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'course_id',
            'instructor_id',
            'semester',
            'academic_year',
            'days',
            'is_active',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $sections = $this->courseService->getAllSections($filters, $perPage);
        
        return response()->json([
            'success' => true,
            'data' => $sections,
            'message' => 'Sections retrieved successfully'
        ]);
    }

    /**
     * Store a newly created section.
     *
     * @param SectionRequest $request
     * @return JsonResponse
     */
    public function store(SectionRequest $request): JsonResponse
    {
        try {
            $section = $this->courseService->createSection($request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $section,
                'message' => 'Section created successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified section with enrollments.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $section = $this->courseService->getSectionById($id);
        
        return response()->json([
            'success' => true,
            'data' => $section,
            'message' => 'Section retrieved successfully'
        ]);
    }

    /**
     * Update the specified section.
     *
     * @param SectionRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(SectionRequest $request, int $id): JsonResponse
    {
        try {
            $section = $this->courseService->updateSection($id, $request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $section,
                'message' => 'Section updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified section.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->courseService->deleteSection($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Section deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get detailed information about a section including enrollment status.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getSectionDetails(int $id): JsonResponse
    {
        $sectionDetails = $this->courseService->getSectionDetails($id);
        
        return response()->json([
            'success' => true,
            'data' => $sectionDetails,
            'message' => 'Section details retrieved successfully'
        ]);
    }

    /**
     * Update the capacity of a section.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCapacity(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'capacity' => 'required|integer|min:1',
            'waitlist_capacity' => 'nullable|integer|min:0',
        ]);
        
        try {
            $section = $this->courseService->updateSectionCapacity(
                $id, 
                $request->input('capacity'),
                $request->input('waitlist_capacity')
            );
            
            return response()->json([
                'success' => true,
                'data' => $section,
                'message' => 'Section capacity updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Check section availability (open seats, etc).
     *
     * @param int $id
     * @return JsonResponse
     */
    public function checkAvailability(int $id): JsonResponse
    {
        $availability = $this->courseService->checkSectionAvailability($id);
        
        return response()->json([
            'success' => true,
            'data' => $availability,
            'message' => 'Section availability retrieved successfully'
        ]);
    }
}
