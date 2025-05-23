<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Section;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of exams.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Exam::with(['course', 'section', 'academicTerm']);
        
        // Filter by course if provided
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        
        // Filter by section if provided
        if ($request->has('section_id')) {
            $query->where('section_id', $request->section_id);
        }
        
        // Filter by academic term if provided
        if ($request->has('academic_term_id')) {
            $query->where('academic_term_id', $request->academic_term_id);
        }
        
        // Filter by exam type if provided
        if ($request->has('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('start_datetime', [$request->start_date, $request->end_date]);
        }
        
        // Filter by published status if provided
        if ($request->has('is_published')) {
            $query->where('is_published', $request->boolean('is_published'));
        }
        
        $exams = $query->orderBy('start_datetime')->get();
        
        return response()->json([
            'success' => true,
            'data' => $exams
        ]);
    }

    /**
     * Store a newly created exam.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'section_id' => 'nullable|exists:sections,id',
            'academic_term_id' => 'required|exists:academic_terms,id',
            'title' => 'required|string|max:255',
            'exam_type' => 'required|in:midterm,final,quiz,assignment,project,other',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'duration_minutes' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'weight' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1|lte:total_marks',
            'is_published' => 'boolean',
            'allow_retake' => 'boolean',
            'is_proctored' => 'boolean',
            'is_online' => 'boolean',
            'allowed_materials' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate that section belongs to course if provided
        if ($request->has('section_id')) {
            $section = Section::findOrFail($request->section_id);
            if ($section->course_id != $request->course_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Section does not belong to the specified course'
                ], 422);
            }
        }
        
        // Add the user ID as creator
        $data = $request->all();
        $data['created_by'] = Auth::id();
        
        $exam = Exam::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Exam created successfully',
            'data' => $exam
        ], 201);
    }

    /**
     * Display the specified exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $exam = Exam::with(['course', 'section', 'academicTerm', 'creator'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $exam
        ]);
    }

    /**
     * Update the specified exam.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $exam = Exam::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'course_id' => 'exists:courses,id',
            'section_id' => 'nullable|exists:sections,id',
            'academic_term_id' => 'exists:academic_terms,id',
            'title' => 'string|max:255',
            'exam_type' => 'in:midterm,final,quiz,assignment,project,other',
            'start_datetime' => 'date',
            'end_datetime' => 'date|after:start_datetime',
            'duration_minutes' => 'integer|min:1',
            'location' => 'nullable|string|max:255',
            'weight' => 'numeric|min:0|max:100',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'total_marks' => 'integer|min:1',
            'passing_marks' => 'integer|min:1|lte:total_marks',
            'is_published' => 'boolean',
            'allow_retake' => 'boolean',
            'is_proctored' => 'boolean',
            'is_online' => 'boolean',
            'allowed_materials' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate that section belongs to course if both are provided
        if ($request->has('section_id') && $request->has('course_id')) {
            $section = Section::findOrFail($request->section_id);
            if ($section->course_id != $request->course_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Section does not belong to the specified course'
                ], 422);
            }
        } elseif ($request->has('section_id')) {
            $section = Section::findOrFail($request->section_id);
            if ($section->course_id != $exam->course_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Section does not belong to the exam course'
                ], 422);
            }
        }
        
        $exam->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Exam updated successfully',
            'data' => $exam
        ]);
    }

    /**
     * Remove the specified exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $exam = Exam::findOrFail($id);
        
        // Check if exam already has results
        if ($exam->results()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete exam with recorded results'
            ], 409);
        }
        
        $exam->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Exam deleted successfully'
        ]);
    }

    /**
     * Publish the specified exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish($id): JsonResponse
    {
        $exam = Exam::findOrFail($id);
        $exam->is_published = true;
        $exam->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Exam published successfully',
            'data' => $exam
        ]);
    }

    /**
     * Unpublish the specified exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unpublish($id): JsonResponse
    {
        $exam = Exam::findOrFail($id);
        $exam->is_published = false;
        $exam->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Exam unpublished successfully',
            'data' => $exam
        ]);
    }

    /**
     * Get all eligible students for an exam.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEligibleStudents($id): JsonResponse
    {
        $exam = Exam::findOrFail($id);
        $students = $exam->getEligibleStudents();
        
        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    /**
     * Get upcoming exams for a student.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcomingExams(Request $request): JsonResponse
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        
        $exams = Exam::with(['course', 'section'])
            ->whereIn('course_id', $student->courses()->pluck('courses.id'))
            ->where('is_published', true)
            ->where('start_datetime', '>', now())
            ->orderBy('start_datetime')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $exams
        ]);
    }

    /**
     * Get past exams for a student.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pastExams(Request $request): JsonResponse
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        
        $exams = Exam::with(['course', 'section'])
            ->whereIn('course_id', $student->courses()->pluck('courses.id'))
            ->where('is_published', true)
            ->where('end_datetime', '<', now())
            ->orderBy('start_datetime', 'desc')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $exams
        ]);
    }
}
