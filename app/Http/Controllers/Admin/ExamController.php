<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Course;
use App\Models\Section;
use App\Models\AcademicTerm;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|faculty']);
    }

    /**
     * Display a listing of exams.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        
        // Faculty can only see their own exams
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin')) {
            $query->where('created_by', Auth::id());
        }
        
        $exams = $query->orderBy('start_datetime')->paginate(15);
        $courses = Course::orderBy('name')->get();
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('admin.exams.index', compact('exams', 'courses', 'terms'));
    }

    /**
     * Show the form for creating a new exam.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::orderBy('name')->get();
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('admin.exams.create', compact('courses', 'terms'));
    }

    /**
     * Store a newly created exam in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate that section belongs to course if provided
        if ($request->has('section_id') && $request->section_id) {
            $section = Section::findOrFail($request->section_id);
            if ($section->course_id != $request->course_id) {
                return redirect()->back()
                    ->with('error', 'Section does not belong to the specified course')
                    ->withInput();
            }
        }
        
        // Add the user ID as creator
        $data = $request->all();
        $data['created_by'] = Auth::id();
        
        // Handle allowed materials as JSON
        if ($request->has('allowed_materials')) {
            $data['allowed_materials'] = json_encode($request->allowed_materials);
        }
        
        Exam::create($data);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam created successfully');
    }

    /**
     * Display the specified exam.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        // Check if faculty has permission to view this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'You do not have permission to view this exam');
        }
        
        $exam->load(['course', 'section', 'academicTerm', 'creator', 'results']);
        
        // Calculate statistics
        $stats = [
            'total_students' => $exam->results->count(),
            'absent_students' => $exam->results->where('is_absent', true)->count(),
            'average_score' => $exam->results->where('is_absent', false)->avg('score'),
            'highest_score' => $exam->results->where('is_absent', false)->max('score'),
            'lowest_score' => $exam->results->where('is_absent', false)->min('score'),
            'passing_count' => $exam->results->where('is_absent', false)->filter(function($result) use ($exam) {
                return $result->score >= $exam->passing_marks;
            })->count(),
            'failing_count' => $exam->results->where('is_absent', false)->filter(function($result) use ($exam) {
                return $result->score < $exam->passing_marks;
            })->count(),
        ];
        
        return view('admin.exams.show', compact('exam', 'stats'));
    }

    /**
     * Show the form for editing the specified exam.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        // Check if faculty has permission to edit this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'You do not have permission to edit this exam');
        }
        
        $courses = Course::orderBy('name')->get();
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        $sections = Section::where('course_id', $exam->course_id)->get();
        
        return view('admin.exams.edit', compact('exam', 'courses', 'terms', 'sections'));
    }

    /**
     * Update the specified exam in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        // Check if faculty has permission to update this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'You do not have permission to update this exam');
        }
        
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate that section belongs to course if provided
        if ($request->has('section_id') && $request->section_id) {
            $section = Section::findOrFail($request->section_id);
            if ($section->course_id != $request->course_id) {
                return redirect()->back()
                    ->with('error', 'Section does not belong to the specified course')
                    ->withInput();
            }
        }
        
        // Handle allowed materials as JSON
        $data = $request->all();
        if ($request->has('allowed_materials')) {
            $data['allowed_materials'] = json_encode($request->allowed_materials);
        }
        
        $exam->update($data);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam updated successfully');
    }

    /**
     * Remove the specified exam from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        // Check if faculty has permission to delete this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'You do not have permission to delete this exam');
        }
        
        // Check if exam has results
        if ($exam->results()->count() > 0) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'Cannot delete exam with recorded results');
        }
        
        $exam->delete();
        
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully');
    }

    /**
     * Publish the specified exam.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function publish(Exam $exam)
    {
        // Check if faculty has permission to publish this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'You do not have permission to publish this exam');
        }
        
        $exam->is_published = true;
        $exam->save();
        
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam published successfully');
    }

    /**
     * Unpublish the specified exam.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function unpublish(Exam $exam)
    {
        // Check if faculty has permission to unpublish this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'You do not have permission to unpublish this exam');
        }
        
        $exam->is_published = false;
        $exam->save();
        
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam unpublished successfully');
    }

    /**
     * Show the form for recording exam results.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function recordResults(Exam $exam)
    {
        // Check if faculty has permission to record results for this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'You do not have permission to record results for this exam');
        }
        
        $exam->load(['course', 'section', 'academicTerm']);
        $students = $exam->getEligibleStudents()->with('user')->get();
        $existingResults = $exam->results()->get()->keyBy('student_id');
        
        return view('admin.exams.record-results', compact('exam', 'students', 'existingResults'));
    }

    /**
     * Store exam results for multiple students.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function storeResults(Request $request, Exam $exam)
    {
        // Check if faculty has permission to store results for this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'You do not have permission to store results for this exam');
        }
        
        $validator = Validator::make($request->all(), [
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:students,id',
            'results.*.score' => 'required|numeric|min:0|max:' . $exam->total_marks,
            'results.*.is_absent' => 'boolean',
            'results.*.is_excused' => 'boolean',
            'results.*.absence_reason' => 'nullable|string',
            'results.*.feedback' => 'nullable|string',
            'notify_students' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $savedResults = 0;
        foreach ($request->results as $studentId => $resultData) {
            $existingResult = $exam->results()->where('student_id', $studentId)->first();
            
            if ($existingResult) {
                // Update existing result
                $existingResult->score = $resultData['score'];
                $existingResult->grade = $existingResult->generateGrade();
                $existingResult->status = 'graded';
                $existingResult->feedback = $resultData['feedback'] ?? null;
                $existingResult->is_absent = isset($resultData['is_absent']) ? (bool)$resultData['is_absent'] : false;
                $existingResult->is_excused = isset($resultData['is_excused']) ? (bool)$resultData['is_excused'] : false;
                $existingResult->absence_reason = $resultData['absence_reason'] ?? null;
                $existingResult->graded_at = now();
                $existingResult->graded_by = Auth::id();
                $existingResult->save();
                
                $savedResults++;
            } else {
                // Create new result
                $newResult = $exam->results()->create([
                    'student_id' => $studentId,
                    'score' => $resultData['score'],
                    'status' => 'graded',
                    'feedback' => $resultData['feedback'] ?? null,
                    'is_absent' => isset($resultData['is_absent']) ? (bool)$resultData['is_absent'] : false,
                    'is_excused' => isset($resultData['is_excused']) ? (bool)$resultData['is_excused'] : false,
                    'absence_reason' => $resultData['absence_reason'] ?? null,
                    'graded_at' => now(),
                    'graded_by' => Auth::id(),
                ]);
                
                // Generate and save grade
                $newResult->grade = $newResult->generateGrade();
                $newResult->save();
                
                $savedResults++;
            }
        }
        
        // Notify students if requested
        if ($request->boolean('notify_students', false)) {
            $students = Student::whereIn('id', array_keys($request->results))
                ->with('user')
                ->get();
                
            foreach ($students as $student) {
                if ($student->user) {
                    $student->user->notify(new \App\Notifications\GradePostedNotification($exam));
                }
            }
        }

        return redirect()->route('admin.exams.show', $exam)
            ->with('success', $savedResults . ' exam results recorded successfully');
    }
}
