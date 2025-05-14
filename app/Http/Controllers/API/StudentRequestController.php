<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class StudentRequestController extends Controller
{
    /**
     * Constructor with middleware
     */
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('permission:view-student-request')->only(['index', 'show', 'getStudentRequests']);
        $this->middleware('permission:manage-student-request')->only(['store', 'update', 'destroy', 'approve', 'reject']);
    }

    /**
     * Display a paginated listing of student requests.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'student_id',
            'type',
            'status',
            'priority',
            'date_range',
            'search',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $requests = StudentRequest::query()
            ->with('student')
            ->when(isset($filters['student_id']), function ($query) use ($filters) {
                return $query->where('student_id', $filters['student_id']);
            })
            ->when(isset($filters['type']), function ($query) use ($filters) {
                return $query->where('type', $filters['type']);
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                return $query->where('status', $filters['status']);
            })
            ->when(isset($filters['priority']), function ($query) use ($filters) {
                return $query->where('priority', $filters['priority']);
            })
            ->when(isset($filters['date_range']), function ($query) use ($filters) {
                $dates = explode(',', $filters['date_range']);
                if (count($dates) == 2) {
                    return $query->whereBetween('created_at', $dates);
                }
                return $query;
            })
            ->when(isset($filters['search']), function ($query) use ($filters) {
                return $query->where('request_id', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('subject', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            })
            ->latest()
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $requests,
            'message' => 'Student requests retrieved successfully'
        ]);
    }

    /**
     * Store a newly created student request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string|in:transcript,enrollment_verification,grade_change,withdrawal,leave_of_absence,course_override,financial_aid,other',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string|in:low,medium,high',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // 10MB max per file
        ]);
        
        try {
            // Generate a unique request ID
            $requestId = 'REQ-' . time() . '-' . $request->input('student_id');
            
            // Create the student request
            $studentRequest = StudentRequest::create([
                'student_id' => $request->input('student_id'),
                'request_id' => $requestId,
                'type' => $request->input('type'),
                'subject' => $request->input('subject'),
                'description' => $request->input('description'),
                'priority' => $request->input('priority'),
                'status' => 'pending',
                'submitted_by' => auth()->id(),
            ]);
            
            // Handle file attachments if any
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('student_requests/' . $studentRequest->id, 'public');
                    $studentRequest->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
            
            // Load the relationships for the response
            $studentRequest->load('student', 'attachments');
            
            return response()->json([
                'success' => true,
                'data' => $studentRequest,
                'message' => 'Student request created successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified student request.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $studentRequest = StudentRequest::with(['student', 'attachments', 'submittedBy', 'processedBy'])
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $studentRequest,
            'message' => 'Student request retrieved successfully'
        ]);
    }

    /**
     * Update the specified student request.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $studentRequest = StudentRequest::findOrFail($id);
        
        // Only allow updates if the request is pending
        if ($studentRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update a request that has been ' . $studentRequest->status
            ], 400);
        }
        
        $request->validate([
            'type' => 'nullable|string|in:transcript,enrollment_verification,grade_change,withdrawal,leave_of_absence,course_override,financial_aid,other',
            'subject' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // 10MB max per file
        ]);
        
        try {
            // Update the student request
            $studentRequest->update($request->only(['type', 'subject', 'description', 'priority']));
            
            // Handle file attachments if any
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('student_requests/' . $studentRequest->id, 'public');
                    $studentRequest->attachments()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
            
            // Load the relationships for the response
            $studentRequest->load('student', 'attachments');
            
            return response()->json([
                'success' => true,
                'data' => $studentRequest,
                'message' => 'Student request updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified student request.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $studentRequest = StudentRequest::findOrFail($id);
            
            // Only allow deletion if the request is pending and by the submitter
            if ($studentRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete a request that has been ' . $studentRequest->status
                ], 400);
            }
            
            // Delete attachments if any
            if ($studentRequest->attachments()->count() > 0) {
                foreach ($studentRequest->attachments as $attachment) {
                    // Delete the file from storage
                    if (\Storage::disk('public')->exists($attachment->file_path)) {
                        \Storage::disk('public')->delete($attachment->file_path);
                    }
                }
                
                // Delete the attachment records
                $studentRequest->attachments()->delete();
            }
            
            // Delete the request
            $studentRequest->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Student request deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get all requests for a specific student.
     *
     * @param int $studentId
     * @param Request $request
     * @return JsonResponse
     */
    public function getStudentRequests(int $studentId, Request $request): JsonResponse
    {
        $filters = $request->only([
            'type',
            'status',
            'priority',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $requests = StudentRequest::query()
            ->where('student_id', $studentId)
            ->when(isset($filters['type']), function ($query) use ($filters) {
                return $query->where('type', $filters['type']);
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                return $query->where('status', $filters['status']);
            })
            ->when(isset($filters['priority']), function ($query) use ($filters) {
                return $query->where('priority', $filters['priority']);
            })
            ->with('attachments')
            ->latest()
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $requests,
            'message' => 'Student requests retrieved successfully'
        ]);
    }

    /**
     * Approve a student request.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function approve(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'comments' => 'nullable|string',
        ]);
        
        try {
            $studentRequest = StudentRequest::findOrFail($id);
            
            // Only allow approval if the request is pending
            if ($studentRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot approve a request that has been ' . $studentRequest->status
                ], 400);
            }
            
            $result = $studentRequest->approve(
                auth()->id(),
                $request->input('comments')
            );
            
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Student request approved successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Reject a student request.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function reject(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string',
        ]);
        
        try {
            $studentRequest = StudentRequest::findOrFail($id);
            
            // Only allow rejection if the request is pending
            if ($studentRequest->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot reject a request that has been ' . $studentRequest->status
                ], 400);
            }
            
            $result = $studentRequest->reject(
                auth()->id(),
                $request->input('reason')
            );
            
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Student request rejected successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
