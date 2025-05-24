<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationStatusUpdated;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|admissions']);
    }

    /**
     * Display a listing of the applications.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $query = Application::with(['user', 'reviewer']);
        
        // Filter by status if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        // Apply search filter if provided
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Sort applications
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);
        
        $applications = $query->paginate(15);
        
        return view('admin.applications.index', compact('applications', 'status'));
    }

    /**
     * Display the specified application.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $application = Application::with(['user', 'reviewer'])->findOrFail($id);
        
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $application = Application::with(['user', 'reviewer'])->findOrFail($id);
        
        return view('admin.applications.edit', compact('application'));
    }

    /**
     * Update the specified application status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:1000',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $application = Application::findOrFail($id);
        
        // Don't allow re-reviewing already processed applications
        if ($application->status !== 'pending') {
            return back()->with('error', 'This application has already been processed.');
        }
        
        // Update application status
        $application->status = $request->status;
        $application->notes = $request->notes;
        $application->reviewed_by = Auth::id();
        $application->reviewed_at = now();
        
        if ($request->status === 'rejected') {
            $application->rejection_reason = $request->rejection_reason;
        } else {
            $application->rejection_reason = null;
        }
        
        $application->save();
        
        // If approved, create or update student record
        if ($request->status === 'approved') {
            $this->createStudentRecord($application);
        }
        
        // Send notification email to the applicant
        try {
            Mail::to($application->user->email)
                ->send(new ApplicationStatusUpdated($application));
        } catch (\Exception $e) {
            Log::error('Failed to send application status email', [
                'application_id' => $application->id,
                'error' => $e->getMessage()
            ]);
        }
        
        return redirect()->route('admin.applications.index')
                         ->with('success', 'Application has been ' . $request->status . ' successfully.');
    }

    /**
     * Create a student record for an approved application.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    private function createStudentRecord(Application $application)
    {
        // Check if student record already exists
        $existingStudent = Student::where('user_id', $application->user_id)->first();
        
        if ($existingStudent) {
            // Update existing student record if needed
            $existingStudent->academic_standing = 'Active';
            $existingStudent->save();
            
            Log::info('Updated existing student record', [
                'student_id' => $existingStudent->id,
                'application_id' => $application->id
            ]);
            
            return;
        }
        
        // Generate unique student ID with 23010 prefix
        $studentId = $this->generateStudentId();
        
        // Create new student record
        $student = new Student([
            'user_id' => $application->user_id,
            'student_id' => $studentId,
            'admission_date' => now(),
            'expected_graduation_date' => now()->addYears(4),
            'academic_standing' => 'Active',
            'level' => 'Freshman',
            'credits_completed' => 0,
            'gpa' => 0.00,
        ]);
        
        $student->save();
        
        // Assign student role to user if not already assigned
        $user = User::find($application->user_id);
        if (!$user->hasRole('student')) {
            $user->assignRole('student');
        }
        
        Log::info('Created new student record', [
            'student_id' => $student->id,
            'university_id' => $studentId,
            'application_id' => $application->id
        ]);
    }

    /**
     * Generate a unique student ID with 23010 prefix.
     *
     * @return string
     */
    private function generateStudentId()
    {
        $prefix = '23010';
        $uniqueFound = false;
        $studentId = null;
        
        while (!$uniqueFound) {
            // Generate 4 random digits
            $randomDigits = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $studentId = $prefix . $randomDigits;
            
            // Check if this ID already exists
            $exists = Student::where('student_id', $studentId)->exists();
            
            if (!$exists) {
                $uniqueFound = true;
            }
        }
        
        return $studentId;
    }
}
