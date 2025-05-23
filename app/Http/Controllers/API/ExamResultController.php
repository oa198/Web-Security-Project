<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\GradePostedNotification;

class ExamResultController extends Controller
{
    /**
     * Display a listing of exam results.
     *
     * @param Request $request
     * @param int $examId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $examId): JsonResponse
    {
        $exam = Exam::findOrFail($examId);
        
        $query = ExamResult::with(['student', 'student.user'])
            ->where('exam_id', $examId);
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter to show only absences if requested
        if ($request->boolean('absences_only', false)) {
            $query->where('is_absent', true);
        }
        
        $results = $query->get();
        
        // Calculate statistics
        $stats = [
            'total_students' => $results->count(),
            'average_score' => $results->where('is_absent', false)->avg('score'),
            'highest_score' => $results->where('is_absent', false)->max('score'),
            'lowest_score' => $results->where('is_absent', false)->min('score'),
            'passing_count' => $results->where('is_absent', false)->filter(function($result) use ($exam) {
                return $result->score >= $exam->passing_marks;
            })->count(),
            'failing_count' => $results->where('is_absent', false)->filter(function($result) use ($exam) {
                return $result->score < $exam->passing_marks;
            })->count(),
            'absent_count' => $results->where('is_absent', true)->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => [
                'results' => $results,
                'statistics' => $stats
            ]
        ]);
    }

    /**
     * Store exam results for multiple students.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $examId
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBatch(Request $request, $examId): JsonResponse
    {
        $exam = Exam::findOrFail($examId);
        
        $validator = Validator::make($request->all(), [
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:students,id',
            'results.*.score' => 'required|numeric|min:0|max:' . $exam->total_marks,
            'results.*.is_absent' => 'boolean',
            'results.*.is_excused' => 'boolean',
            'results.*.absence_reason' => 'nullable|string',
            'results.*.feedback' => 'nullable|string',
            'results.*.section_scores' => 'nullable|array',
            'notify_students' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $results = [];
        $studentsToNotify = [];
        
        foreach ($request->results as $resultData) {
            $existingResult = ExamResult::where('exam_id', $examId)
                ->where('student_id', $resultData['student_id'])
                ->first();
                
            if ($existingResult) {
                // Update existing result
                $existingResult->score = $resultData['score'];
                $existingResult->grade = isset($resultData['grade']) ? $resultData['grade'] : null;
                $existingResult->status = 'graded';
                $existingResult->feedback = $resultData['feedback'] ?? null;
                $existingResult->section_scores = $resultData['section_scores'] ?? null;
                $existingResult->is_absent = $resultData['is_absent'] ?? false;
                $existingResult->is_excused = $resultData['is_excused'] ?? false;
                $existingResult->absence_reason = $resultData['absence_reason'] ?? null;
                $existingResult->graded_at = now();
                $existingResult->graded_by = Auth::id();
                $existingResult->save();
                
                $results[] = $existingResult;
                $studentsToNotify[] = $existingResult->student;
            } else {
                // Create new result
                $newResult = new ExamResult();
                $newResult->exam_id = $examId;
                $newResult->student_id = $resultData['student_id'];
                $newResult->score = $resultData['score'];
                $newResult->grade = isset($resultData['grade']) ? $resultData['grade'] : null;
                $newResult->status = 'graded';
                $newResult->feedback = $resultData['feedback'] ?? null;
                $newResult->section_scores = $resultData['section_scores'] ?? null;
                $newResult->is_absent = $resultData['is_absent'] ?? false;
                $newResult->is_excused = $resultData['is_excused'] ?? false;
                $newResult->absence_reason = $resultData['absence_reason'] ?? null;
                $newResult->graded_at = now();
                $newResult->graded_by = Auth::id();
                $newResult->save();
                
                $results[] = $newResult;
                $studentsToNotify[] = $newResult->student;
            }
        }
        
        // Notify students if requested
        if ($request->boolean('notify_students', false)) {
            foreach ($studentsToNotify as $student) {
                // Ensure student has a user relation
                if ($student->user) {
                    Notification::send($student->user, new GradePostedNotification($exam));
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($results) . ' exam results recorded successfully',
            'data' => $results
        ], 201);
    }

    /**
     * Store a new exam result for a single student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $examId
     * @param  int  $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $examId, $studentId): JsonResponse
    {
        $exam = Exam::findOrFail($examId);
        $student = Student::findOrFail($studentId);
        
        $validator = Validator::make($request->all(), [
            'score' => 'required|numeric|min:0|max:' . $exam->total_marks,
            'grade' => 'nullable|string|max:5',
            'feedback' => 'nullable|string',
            'section_scores' => 'nullable|array',
            'is_absent' => 'boolean',
            'is_excused' => 'boolean',
            'absence_reason' => 'nullable|string',
            'notify_student' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $existingResult = ExamResult::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->first();
            
        if ($existingResult) {
            // Update existing result
            $existingResult->score = $request->score;
            $existingResult->grade = $request->grade ?? $existingResult->generateGrade();
            $existingResult->status = 'graded';
            $existingResult->feedback = $request->feedback;
            $existingResult->section_scores = $request->section_scores;
            $existingResult->is_absent = $request->boolean('is_absent', false);
            $existingResult->is_excused = $request->boolean('is_excused', false);
            $existingResult->absence_reason = $request->absence_reason;
            $existingResult->graded_at = now();
            $existingResult->graded_by = Auth::id();
            $existingResult->save();
            
            $result = $existingResult;
        } else {
            // Create new result
            $result = new ExamResult();
            $result->exam_id = $examId;
            $result->student_id = $studentId;
            $result->score = $request->score;
            $result->grade = $request->grade ?? null;
            $result->status = 'graded';
            $result->feedback = $request->feedback;
            $result->section_scores = $request->section_scores;
            $result->is_absent = $request->boolean('is_absent', false);
            $result->is_excused = $request->boolean('is_excused', false);
            $result->absence_reason = $request->absence_reason;
            $result->graded_at = now();
            $result->graded_by = Auth::id();
            $result->save();
            
            // If grade not provided, generate one
            if (!$request->has('grade')) {
                $result->grade = $result->generateGrade();
                $result->save();
            }
        }
        
        // Notify student if requested
        if ($request->boolean('notify_student', false) && $student->user) {
            $student->user->notify(new GradePostedNotification($exam));
        }

        return response()->json([
            'success' => true,
            'message' => 'Exam result recorded successfully',
            'data' => $result
        ], 201);
    }

    /**
     * Display the specified exam result.
     *
     * @param  int  $examId
     * @param  int  $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($examId, $studentId): JsonResponse
    {
        $result = ExamResult::with(['exam', 'student', 'student.user', 'gradedBy'])
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->firstOrFail();
        
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * Update the specified exam result.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $examId
     * @param  int  $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $examId, $studentId): JsonResponse
    {
        $exam = Exam::findOrFail($examId);
        $student = Student::findOrFail($studentId);
        
        $result = ExamResult::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'score' => 'numeric|min:0|max:' . $exam->total_marks,
            'grade' => 'nullable|string|max:5',
            'status' => 'in:pending,graded,under_review,finalized',
            'feedback' => 'nullable|string',
            'section_scores' => 'nullable|array',
            'is_absent' => 'boolean',
            'is_excused' => 'boolean',
            'absence_reason' => 'nullable|string',
            'notify_student' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Update the result
        if ($request->has('score')) {
            $result->score = $request->score;
        }
        
        if ($request->has('grade')) {
            $result->grade = $request->grade;
        }
        
        if ($request->has('status')) {
            $result->status = $request->status;
        }
        
        if ($request->has('feedback')) {
            $result->feedback = $request->feedback;
        }
        
        if ($request->has('section_scores')) {
            $result->section_scores = $request->section_scores;
        }
        
        if ($request->has('is_absent')) {
            $result->is_absent = $request->boolean('is_absent');
        }
        
        if ($request->has('is_excused')) {
            $result->is_excused = $request->boolean('is_excused');
        }
        
        if ($request->has('absence_reason')) {
            $result->absence_reason = $request->absence_reason;
        }
        
        $result->graded_at = now();
        $result->graded_by = Auth::id();
        $result->save();
        
        // Notify student if requested
        if ($request->boolean('notify_student', false) && $student->user) {
            $student->user->notify(new GradePostedNotification($exam));
        }

        return response()->json([
            'success' => true,
            'message' => 'Exam result updated successfully',
            'data' => $result
        ]);
    }

    /**
     * Remove the specified exam result.
     *
     * @param  int  $examId
     * @param  int  $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($examId, $studentId): JsonResponse
    {
        $result = ExamResult::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->firstOrFail();
        
        $result->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Exam result deleted successfully'
        ]);
    }

    /**
     * Get all exam results for a student.
     *
     * @param  int  $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentResults($studentId): JsonResponse
    {
        $student = Student::findOrFail($studentId);
        
        $results = ExamResult::with(['exam', 'exam.course'])
            ->where('student_id', $studentId)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }

    /**
     * Get current user's exam results.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyResults(): JsonResponse
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();
        
        $results = ExamResult::with(['exam', 'exam.course'])
            ->where('student_id', $student->id)
            ->get()
            ->groupBy('exam.course.name');
        
        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
}
