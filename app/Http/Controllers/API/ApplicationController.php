<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the applications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Only admins/admissions officers can view all applications
        if (!$request->user()->hasAnyRole(['admin', 'admissions'])) {
            // Regular users can only see their own applications
            $applications = Application::where('user_id', Auth::id())
                ->with('reviewer:id,name')
                ->orderBy('created_at', 'desc')
                ->get();
                
            return response()->json([
                'success' => true,
                'data' => $applications
            ]);
        }
        
        // Admin/admissions view with filtering
        $status = $request->get('status');
        $query = Application::with(['user:id,name,email', 'reviewer:id,name']);
        
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
        
        return response()->json([
            'success' => true,
            'data' => $applications
        ]);
    }

    /**
     * Store a newly created application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Check if user already has a pending or approved application
        $existingApplication = Application::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();
            
        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a ' . $existingApplication->status . ' application.',
                'application' => $existingApplication
            ], 422);
        }
        
        // Process document uploads
        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $path = $file->store('application-documents', 'public');
                $documents[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ];
            }
        }
        
        // Create the application
        $application = Application::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'documents' => $documents,
            'notes' => $request->notes,
        ]);
        
        // Log the application submission
        Log::info('Application submitted', [
            'user_id' => Auth::id(),
            'application_id' => $application->id
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Your application has been submitted successfully and is pending review.',
            'data' => $application
        ], 201);
    }

    /**
     * Display the specified application.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $application = Application::with(['user:id,name,email', 'reviewer:id,name'])
            ->findOrFail($id);
            
        // Check if the user is authorized to view this application
        if (!Auth::user()->hasAnyRole(['admin', 'admissions']) && $application->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this application.'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => $application
        ]);
    }

    /**
     * Update the specified application.
     * Only admins and admissions officers can update application status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        // Only admins and admissions officers can update applications
        if (!Auth::user()->hasAnyRole(['admin', 'admissions'])) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update application status.'
            ], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:1000',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $application = Application::findOrFail($id);
        
        // Don't allow re-reviewing already processed applications
        if ($application->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This application has already been processed.'
            ], 422);
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
        
        return response()->json([
            'success' => true,
            'message' => 'Application status updated to ' . $request->status,
            'data' => $application
        ]);
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
    
    /**
     * Get application statistics (for admins/admissions only).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        // Only admins and admissions officers can view statistics
        if (!Auth::user()->hasAnyRole(['admin', 'admissions'])) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view application statistics.'
            ], 403);
        }
        
        $stats = [
            'total' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'approved' => Application::where('status', 'approved')->count(),
            'rejected' => Application::where('status', 'rejected')->count(),
            'today' => Application::whereDate('created_at', Carbon::today())->count(),
            'this_week' => Application::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'this_month' => Application::whereMonth('created_at', Carbon::now()->month)
                                     ->whereYear('created_at', Carbon::now()->year)
                                     ->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
