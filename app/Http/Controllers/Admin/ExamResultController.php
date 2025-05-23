<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Models\Exam;
use App\Models\Student;
use App\Notifications\GradePostedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ExamResultController extends Controller
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
     * Display a listing of exam results.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ExamResult::with(['exam', 'student.user', 'gradedBy']);
        
        // Filter by exam if provided
        if ($request->has('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }
        
        // Filter by student if provided
        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by grade if provided
        if ($request->has('grade')) {
            $query->where('grade', $request->grade);
        }
        
        // Faculty can only see results for exams they created
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin')) {
            $query->whereHas('exam', function($q) {
                $q->where('created_by', Auth::id());
            });
        }
        
        $results = $query->orderBy('created_at', 'desc')->paginate(20);
        $exams = Exam::orderBy('title')->get();
        
        return view('admin.exam-results.index', compact('results', 'exams'));
    }

    /**
     * Show the form for creating a new exam result.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $exams = Exam::orderBy('title')->get();
        
        // Pre-select exam if provided in request
        $selectedExam = null;
        if ($request->has('exam_id')) {
            $selectedExam = Exam::find($request->exam_id);
            
            // Check if faculty has permission to add results for this exam
            if ($selectedExam && Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') 
                && $selectedExam->created_by != Auth::id()) {
                return redirect()->route('admin.exam-results.index')
                    ->with('error', 'You do not have permission to add results for this exam');
            }
        }
        
        // Get eligible students if exam is selected
        $students = [];
        if ($selectedExam) {
            $students = $selectedExam->getEligibleStudents()->with('user')->get();
        }
        
        return view('admin.exam-results.create', compact('exams', 'selectedExam', 'students'));
    }

    /**
     * Store a newly created exam result in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
            'score' => 'required|numeric|min:0',
            'status' => 'required|in:pending,graded,submitted,reviewed,disputed',
            'feedback' => 'nullable|string',
            'is_absent' => 'boolean',
            'is_excused' => 'boolean',
            'absence_reason' => 'nullable|string|required_if:is_absent,1',
            'notify_student' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $exam = Exam::findOrFail($request->exam_id);
        
        // Check if faculty has permission to add results for this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exam-results.index')
                ->with('error', 'You do not have permission to add results for this exam');
        }
        
        // Check if the score is within valid range for the exam
        if ($request->score > $exam->total_marks) {
            return redirect()->back()
                ->with('error', 'Score cannot be greater than the total marks for this exam (' . $exam->total_marks . ')')
                ->withInput();
        }
        
        // Check if a result already exists for this student and exam
        $existingResult = ExamResult::where('exam_id', $request->exam_id)
            ->where('student_id', $request->student_id)
            ->first();
        
        if ($existingResult) {
            return redirect()->back()
                ->with('error', 'A result already exists for this student and exam')
                ->withInput();
        }
        
        // Create the exam result
        $examResult = new ExamResult();
        $examResult->exam_id = $request->exam_id;
        $examResult->student_id = $request->student_id;
        $examResult->score = $request->score;
        $examResult->status = $request->status;
        $examResult->feedback = $request->feedback;
        $examResult->is_absent = $request->boolean('is_absent', false);
        $examResult->is_excused = $request->boolean('is_excused', false);
        $examResult->absence_reason = $request->absence_reason;
        
        // Set grading details if status is graded
        if ($request->status === 'graded') {
            $examResult->graded_at = now();
            $examResult->graded_by = Auth::id();
            $examResult->grade = $examResult->generateGrade();
        }
        
        $examResult->save();
        
        // Notify student if requested
        if ($request->boolean('notify_student', false)) {
            $student = Student::with('user')->findOrFail($request->student_id);
            if ($student->user) {
                $student->user->notify(new GradePostedNotification($exam));
            }
        }
        
        return redirect()->route('admin.exam-results.index')
            ->with('success', 'Exam result created successfully');
    }

    /**
     * Display the specified exam result.
     *
     * @param  \App\Models\ExamResult  $examResult
     * @return \Illuminate\Http\Response
     */
    public function show(ExamResult $examResult)
    {
        // Check if faculty has permission to view this result
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') 
            && $examResult->exam->created_by != Auth::id()) {
            return redirect()->route('admin.exam-results.index')
                ->with('error', 'You do not have permission to view this exam result');
        }
        
        $examResult->load(['exam', 'student.user', 'gradedBy']);
        
        return view('admin.exam-results.show', compact('examResult'));
    }

    /**
     * Show the form for editing the specified exam result.
     *
     * @param  \App\Models\ExamResult  $examResult
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamResult $examResult)
    {
        // Check if faculty has permission to edit this result
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') 
            && $examResult->exam->created_by != Auth::id()) {
            return redirect()->route('admin.exam-results.index')
                ->with('error', 'You do not have permission to edit this exam result');
        }
        
        $examResult->load(['exam', 'student.user']);
        
        return view('admin.exam-results.edit', compact('examResult'));
    }

    /**
     * Update the specified exam result in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamResult  $examResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamResult $examResult)
    {
        // Check if faculty has permission to update this result
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') 
            && $examResult->exam->created_by != Auth::id()) {
            return redirect()->route('admin.exam-results.index')
                ->with('error', 'You do not have permission to update this exam result');
        }
        
        $validator = Validator::make($request->all(), [
            'score' => 'required|numeric|min:0',
            'status' => 'required|in:pending,graded,submitted,reviewed,disputed',
            'feedback' => 'nullable|string',
            'is_absent' => 'boolean',
            'is_excused' => 'boolean',
            'absence_reason' => 'nullable|string|required_if:is_absent,1',
            'notify_student' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Check if the score is within valid range for the exam
        if ($request->score > $examResult->exam->total_marks) {
            return redirect()->back()
                ->with('error', 'Score cannot be greater than the total marks for this exam (' . $examResult->exam->total_marks . ')')
                ->withInput();
        }
        
        // Update the exam result
        $examResult->score = $request->score;
        $examResult->status = $request->status;
        $examResult->feedback = $request->feedback;
        $examResult->is_absent = $request->boolean('is_absent', false);
        $examResult->is_excused = $request->boolean('is_excused', false);
        $examResult->absence_reason = $request->absence_reason;
        
        // Update grading details if status is graded
        if ($request->status === 'graded' && $examResult->status !== 'graded') {
            $examResult->graded_at = now();
            $examResult->graded_by = Auth::id();
        }
        
        // Generate and update grade
        $examResult->grade = $examResult->generateGrade();
        $examResult->save();
        
        // Notify student if requested
        if ($request->boolean('notify_student', false)) {
            $student = $examResult->student()->with('user')->first();
            if ($student && $student->user) {
                $student->user->notify(new GradePostedNotification($examResult->exam));
            }
        }
        
        return redirect()->route('admin.exam-results.index')
            ->with('success', 'Exam result updated successfully');
    }

    /**
     * Remove the specified exam result from storage.
     *
     * @param  \App\Models\ExamResult  $examResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamResult $examResult)
    {
        // Check if faculty has permission to delete this result
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') 
            && $examResult->exam->created_by != Auth::id()) {
            return redirect()->route('admin.exam-results.index')
                ->with('error', 'You do not have permission to delete this exam result');
        }
        
        $examResult->delete();
        
        return redirect()->route('admin.exam-results.index')
            ->with('success', 'Exam result deleted successfully');
    }

    /**
     * Show form for bulk grade import.
     *
     * @return \Illuminate\Http\Response
     */
    public function importForm()
    {
        $exams = Exam::orderBy('title')->get();
        
        return view('admin.exam-results.import', compact('exams'));
    }

    /**
     * Process the imported grades from CSV/Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_id' => 'required|exists:exams,id',
            'file' => 'required|file|mimes:csv,txt,xls,xlsx',
            'notify_students' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $exam = Exam::findOrFail($request->exam_id);
        
        // Check if faculty has permission to add results for this exam
        if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
            return redirect()->route('admin.exam-results.index')
                ->with('error', 'You do not have permission to add results for this exam');
        }
        
        // Import the file and process grades
        try {
            // Implementation would depend on package used for imports
            // For example, using Laravel Excel package
            
            // As a placeholder:
            $successCount = 0;
            $errorCount = 0;
            $notifiedCount = 0;
            
            // Placeholder for processing import file
            // In a real implementation, you would use a package like Laravel Excel
            
            return redirect()->route('admin.exam-results.index')
                ->with('success', $successCount . ' results imported successfully. ' . 
                    ($errorCount > 0 ? $errorCount . ' rows had errors. ' : '') . 
                    ($notifiedCount > 0 ? $notifiedCount . ' students notified.' : ''));
                    
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing results: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Download a template for bulk grade import.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadTemplate(Request $request)
    {
        // Check if exam_id is provided
        if ($request->has('exam_id')) {
            $exam = Exam::findOrFail($request->exam_id);
            
            // Check if faculty has permission to access this exam
            if (Auth::user()->hasRole('faculty') && !Auth::user()->hasRole('admin') && $exam->created_by != Auth::id()) {
                return redirect()->route('admin.exam-results.index')
                    ->with('error', 'You do not have permission to access this exam');
            }
            
            // Get students for this exam
            $students = $exam->getEligibleStudents()->with('user')->get();
            
            // Generate CSV template with student information
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="exam_results_template_' . $exam->id . '.csv"',
            ];
            
            $callback = function() use ($students) {
                $file = fopen('php://output', 'w');
                
                // Add header row
                fputcsv($file, ['Student ID', 'Name', 'Email', 'Score', 'Is Absent (1/0)', 'Is Excused (1/0)', 'Absence Reason', 'Feedback']);
                
                // Add student rows
                foreach ($students as $student) {
                    fputcsv($file, [
                        $student->id,
                        $student->user->name,
                        $student->user->email,
                        '', // Empty score field
                        '0', // Default not absent
                        '0', // Default not excused
                        '', // Empty absence reason
                        '', // Empty feedback
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        }
        
        // If no exam_id, generate a generic template
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="exam_results_template_generic.csv"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add header row
            fputcsv($file, ['Student ID', 'Score', 'Is Absent (1/0)', 'Is Excused (1/0)', 'Absence Reason', 'Feedback']);
            
            // Add example row
            fputcsv($file, ['1', '85', '0', '0', '', 'Good work']);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
