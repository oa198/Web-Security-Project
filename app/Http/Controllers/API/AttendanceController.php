<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Constructor with middleware
     */
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('permission:view-attendance')->only(['index', 'show', 'getStudentAttendance', 'getSectionAttendance', 'getAttendanceStatistics']);
        $this->middleware('permission:manage-attendance')->only(['store', 'update', 'destroy', 'recordBulkAttendance']);
    }

    /**
     * Display a paginated listing of attendance records.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'student_id',
            'section_id',
            'date',
            'date_range',
            'status',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $attendance = Attendance::query()
            ->with(['student', 'section', 'section.course'])
            ->when(isset($filters['student_id']), function ($query) use ($filters) {
                return $query->where('student_id', $filters['student_id']);
            })
            ->when(isset($filters['section_id']), function ($query) use ($filters) {
                return $query->where('section_id', $filters['section_id']);
            })
            ->when(isset($filters['date']), function ($query) use ($filters) {
                return $query->whereDate('date', $filters['date']);
            })
            ->when(isset($filters['date_range']), function ($query) use ($filters) {
                $dates = explode(',', $filters['date_range']);
                if (count($dates) == 2) {
                    return $query->whereBetween('date', $dates);
                }
                return $query;
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                return $query->where('status', $filters['status']);
            })
            ->latest('date')
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $attendance,
            'message' => 'Attendance records retrieved successfully'
        ]);
    }

    /**
     * Store a newly created attendance record.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
            'status' => 'required|string|in:present,absent,late,excused',
            'remarks' => 'nullable|string|max:255',
        ]);
        
        try {
            // Check if student is enrolled in the section
            $student = Student::findOrFail($request->input('student_id'));
            $section = Section::findOrFail($request->input('section_id'));
            
            if (!$student->isEnrolledInSection($section->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student is not enrolled in this section'
                ], 400);
            }
            
            // Check if attendance record already exists for this student and date
            $existingRecord = Attendance::where('student_id', $request->input('student_id'))
                ->where('section_id', $request->input('section_id'))
                ->whereDate('date', $request->input('date'))
                ->first();
                
            if ($existingRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendance record already exists for this student on this date'
                ], 400);
            }
            
            // Create the attendance record
            $attendance = Attendance::create([
                'student_id' => $request->input('student_id'),
                'section_id' => $request->input('section_id'),
                'date' => $request->input('date'),
                'status' => $request->input('status'),
                'remarks' => $request->input('remarks'),
                'recorded_by' => auth()->id(),
            ]);
            
            // Load the relationships for the response
            $attendance->load(['student', 'section', 'section.course']);
            
            return response()->json([
                'success' => true,
                'data' => $attendance,
                'message' => 'Attendance record created successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified attendance record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $attendance = Attendance::with(['student', 'section', 'section.course', 'recordedBy'])
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $attendance,
            'message' => 'Attendance record retrieved successfully'
        ]);
    }

    /**
     * Update the specified attendance record.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $attendance = Attendance::findOrFail($id);
        
        $request->validate([
            'status' => 'nullable|string|in:present,absent,late,excused',
            'remarks' => 'nullable|string|max:255',
        ]);
        
        try {
            // Update the attendance record
            $attendance->update($request->only(['status', 'remarks']));
            
            // Log who updated the record
            $attendance->updated_by = auth()->id();
            $attendance->save();
            
            // Load the relationships for the response
            $attendance->load(['student', 'section', 'section.course']);
            
            return response()->json([
                'success' => true,
                'data' => $attendance,
                'message' => 'Attendance record updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified attendance record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $attendance = Attendance::findOrFail($id);
            
            // Only allow deletion if the attendance record is recent (within 24 hours)
            if (Carbon::parse($attendance->created_at)->diffInHours(now()) > 24) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete attendance records older than 24 hours'
                ], 400);
            }
            
            $attendance->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance record deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get attendance records for a specific student.
     *
     * @param int $studentId
     * @param Request $request
     * @return JsonResponse
     */
    public function getStudentAttendance(int $studentId, Request $request): JsonResponse
    {
        $filters = $request->only([
            'section_id',
            'date_range',
            'status',
            'semester',
            'academic_year',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $attendance = Attendance::query()
            ->with(['section', 'section.course'])
            ->where('student_id', $studentId)
            ->when(isset($filters['section_id']), function ($query) use ($filters) {
                return $query->where('section_id', $filters['section_id']);
            })
            ->when(isset($filters['date_range']), function ($query) use ($filters) {
                $dates = explode(',', $filters['date_range']);
                if (count($dates) == 2) {
                    return $query->whereBetween('date', $dates);
                }
                return $query;
            })
            ->when(isset($filters['status']), function ($query) use ($filters) {
                return $query->where('status', $filters['status']);
            })
            ->when(isset($filters['semester']) && isset($filters['academic_year']), function ($query) use ($filters) {
                return $query->whereHas('section', function ($q) use ($filters) {
                    $q->where('semester', $filters['semester'])
                      ->where('academic_year', $filters['academic_year']);
                });
            })
            ->latest('date')
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $attendance,
            'message' => 'Student attendance records retrieved successfully'
        ]);
    }

    /**
     * Get attendance records for a specific section.
     *
     * @param int $sectionId
     * @param Request $request
     * @return JsonResponse
     */
    public function getSectionAttendance(int $sectionId, Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
        ]);
        
        try {
            $section = Section::with('course')->findOrFail($sectionId);
            $date = $request->input('date');
            
            // Get all students enrolled in the section
            $enrolledStudents = $section->enrollments()
                ->with('student')
                ->where('status', 'active')
                ->get()
                ->pluck('student');
            
            // Get all attendance records for this section on this date
            $attendanceRecords = Attendance::where('section_id', $sectionId)
                ->whereDate('date', $date)
                ->get()
                ->keyBy('student_id');
            
            // Prepare the attendance data
            $attendanceData = $enrolledStudents->map(function ($student) use ($attendanceRecords, $sectionId, $date) {
                $record = $attendanceRecords->get($student->id);
                
                return [
                    'student_id' => $student->id,
                    'student_name' => $student->user->name,
                    'student_id_number' => $student->student_id,
                    'section_id' => $sectionId,
                    'date' => $date,
                    'status' => $record ? $record->status : null,
                    'remarks' => $record ? $record->remarks : null,
                    'attendance_id' => $record ? $record->id : null,
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => [
                    'section' => $section,
                    'date' => $date,
                    'attendance' => $attendanceData,
                ],
                'message' => 'Section attendance records retrieved successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Record attendance for multiple students in a section.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function recordBulkAttendance(Request $request): JsonResponse
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
            'attendance_data' => 'required|array',
            'attendance_data.*.student_id' => 'required|exists:students,id',
            'attendance_data.*.status' => 'required|string|in:present,absent,late,excused',
            'attendance_data.*.remarks' => 'nullable|string|max:255',
        ]);
        
        try {
            $sectionId = $request->input('section_id');
            $date = $request->input('date');
            $attendanceData = $request->input('attendance_data');
            
            // Check if the section exists
            $section = Section::findOrFail($sectionId);
            
            // Start a transaction
            \DB::beginTransaction();
            
            $recordedCount = 0;
            $errors = [];
            
            foreach ($attendanceData as $record) {
                $studentId = $record['student_id'];
                
                // Check if student is enrolled in the section
                $isEnrolled = $section->enrollments()
                    ->where('student_id', $studentId)
                    ->where('status', 'active')
                    ->exists();
                    
                if (!$isEnrolled) {
                    $errors[] = "Student ID {$studentId} is not enrolled in this section";
                    continue;
                }
                
                // Check if attendance record already exists
                $existingRecord = Attendance::where('student_id', $studentId)
                    ->where('section_id', $sectionId)
                    ->whereDate('date', $date)
                    ->first();
                    
                if ($existingRecord) {
                    // Update existing record
                    $existingRecord->update([
                        'status' => $record['status'],
                        'remarks' => $record['remarks'] ?? null,
                        'updated_by' => auth()->id(),
                    ]);
                } else {
                    // Create new record
                    Attendance::create([
                        'student_id' => $studentId,
                        'section_id' => $sectionId,
                        'date' => $date,
                        'status' => $record['status'],
                        'remarks' => $record['remarks'] ?? null,
                        'recorded_by' => auth()->id(),
                    ]);
                }
                
                $recordedCount++;
            }
            
            // Commit the transaction
            \DB::commit();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'recorded_count' => $recordedCount,
                    'errors' => $errors,
                ],
                'message' => 'Bulk attendance recorded successfully'
            ], 201);
        } catch (Exception $e) {
            // Rollback in case of error
            \DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get attendance statistics for a specific student or section.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAttendanceStatistics(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'section_id' => 'required|exists:sections,id',
            'semester' => 'nullable|string',
            'academic_year' => 'nullable|string',
        ]);
        
        try {
            $sectionId = $request->input('section_id');
            $studentId = $request->input('student_id');
            
            // Get the attendance records
            $query = Attendance::where('section_id', $sectionId);
            
            if ($studentId) {
                $query->where('student_id', $studentId);
            }
            
            // Add semester and academic year filter if provided
            if ($request->has('semester') && $request->has('academic_year')) {
                $section = Section::find($sectionId);
                if ($section->semester != $request->input('semester') || 
                    $section->academic_year != $request->input('academic_year')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'The specified semester and academic year do not match the section'
                    ], 400);
                }
            }
            
            // Get total attendance count by status
            $statistics = $query->select('status', \DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();
            
            // Calculate attendance percentage
            $totalRecords = array_sum($statistics);
            $presentCount = $statistics['present'] ?? 0;
            $lateCount = $statistics['late'] ?? 0;
            $attendanceRate = $totalRecords > 0 ? 
                round((($presentCount + $lateCount) / $totalRecords) * 100, 2) : 0;
            
            // Get the section details
            $section = Section::with('course')->find($sectionId);
            
            // Get student details if student_id is provided
            $student = $studentId ? Student::with('user')->find($studentId) : null;
            
            return response()->json([
                'success' => true,
                'data' => [
                    'section' => $section,
                    'student' => $student,
                    'statistics' => $statistics,
                    'attendance_rate' => $attendanceRate,
                    'total_records' => $totalRecords,
                ],
                'message' => 'Attendance statistics retrieved successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
