<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Exception;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Document;
use App\Models\FinancialRecord;

class StudentController extends Controller
{
    /**
     * Constructor with middleware
     */
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('permission:view-student')->only(['index', 'show', 'getAcademicHistory', 'getHolds']);
        $this->middleware('permission:manage-student')->only(['store', 'update', 'destroy', 'addHold', 'removeHold']);
    }

    /**
     * Display a paginated listing of students.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'department_id',
            'program',
            'academic_standing',
            'search',
            'semester',
            'academic_year',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $students = Student::query()
            ->with(['user', 'department', 'department.faculty'])
            ->when(isset($filters['department_id']), function ($query) use ($filters) {
                return $query->where('department_id', $filters['department_id']);
            })
            ->when(isset($filters['program']), function ($query) use ($filters) {
                return $query->where('program', $filters['program']);
            })
            ->when(isset($filters['academic_standing']), function ($query) use ($filters) {
                return $query->where('academic_standing', $filters['academic_standing']);
            })
            ->when(isset($filters['search']), function ($query) use ($filters) {
                return $query->where(function ($q) use ($filters) {
                    $q->where('student_id', 'like', '%' . $filters['search'] . '%')
                      ->orWhereHas('user', function ($userQuery) use ($filters) {
                          $userQuery->where('name', 'like', '%' . $filters['search'] . '%')
                                   ->orWhere('email', 'like', '%' . $filters['search'] . '%');
                      });
                });
            })
            ->when(isset($filters['semester']) && isset($filters['academic_year']), function ($query) use ($filters) {
                return $query->whereHas('enrollments', function ($q) use ($filters) {
                    $q->where('semester', $filters['semester'])
                      ->where('academic_year', $filters['academic_year']);
                });
            })
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $students,
            'message' => 'Students retrieved successfully'
        ]);
    }

    /**
     * Store a newly created student.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'student_id' => 'required|string|max:20|unique:students',
            'department_id' => 'required|exists:departments,id',
            'program' => 'required|string|in:undergraduate,graduate,phd',
            'entry_year' => 'required|digits:4',
            'entry_semester' => 'required|string|in:fall,spring,summer',
            'academic_standing' => 'required|string|in:good,probation,suspended,dismissed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other,prefer_not_to_say',
        ]);
        
        try {
            // Start transaction
            DB::beginTransaction();
            
            // Create user
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            
            // Assign student role
            $studentRole = Role::where('name', 'student')->first();
            if ($studentRole) {
                $user->assignRole($studentRole);
            }
            
            // Create student profile
            $student = Student::create([
                'user_id' => $user->id,
                'student_id' => $request->input('student_id'),
                'department_id' => $request->input('department_id'),
                'program' => $request->input('program'),
                'entry_year' => $request->input('entry_year'),
                'entry_semester' => $request->input('entry_semester'),
                'academic_standing' => $request->input('academic_standing'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'postal_code' => $request->input('postal_code'),
                'country' => $request->input('country'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
            ]);
            
            // Commit transaction
            DB::commit();
            
            // Load relationships for response
            $student->load(['user', 'department', 'department.faculty']);
            
            return response()->json([
                'success' => true,
                'data' => $student,
                'message' => 'Student created successfully'
            ], 201);
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified student with related data.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $student = Student::with([
                'user', 
                'department', 
                'department.faculty',
                'enrollments' => function ($query) {
                    $query->with('section.course')
                          ->latest()
                          ->take(10);
                },
                'financialRecords' => function ($query) {
                    $query->latest()
                          ->take(5);
                },
                'holds'
            ])
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $student,
            'message' => 'Student retrieved successfully'
        ]);
    }

    /**
     * Update the specified student.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        
        // Validate the request
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $student->user_id,
            'department_id' => 'nullable|exists:departments,id',
            'program' => 'nullable|string|in:undergraduate,graduate,phd',
            'academic_standing' => 'nullable|string|in:good,probation,suspended,dismissed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other,prefer_not_to_say',
        ]);
        
        try {
            // Start transaction
            DB::beginTransaction();
            
            // Update user if name or email provided
            if ($request->has('name') || $request->has('email')) {
                $userData = [];
                if ($request->has('name')) {
                    $userData['name'] = $request->input('name');
                }
                if ($request->has('email')) {
                    $userData['email'] = $request->input('email');
                }
                
                $student->user->update($userData);
            }
            
            // Update student data
            $studentData = $request->only([
                'department_id',
                'program',
                'academic_standing',
                'phone',
                'address',
                'city',
                'state',
                'postal_code',
                'country',
                'date_of_birth',
                'gender',
            ]);
            
            $student->update($studentData);
            
            // Commit transaction
            DB::commit();
            
            // Load relationships for response
            $student->load(['user', 'department', 'department.faculty']);
            
            return response()->json([
                'success' => true,
                'data' => $student,
                'message' => 'Student updated successfully'
            ]);
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified student.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            
            // Check if student has enrollments
            if ($student->enrollments()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete student with existing enrollments. Deactivate the student instead.'
                ], 400);
            }
            
            // Check if student has financial records
            if ($student->financialRecords()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete student with existing financial records. Deactivate the student instead.'
                ], 400);
            }
            
            // Start transaction
            DB::beginTransaction();
            
            // Delete student record
            $student->delete();
            
            // Delete user account
            $student->user->delete();
            
            // Commit transaction
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully'
            ]);
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get a student's academic history.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getAcademicHistory(int $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        
        // Get all completed enrollments grouped by semester
        $academicHistory = $student->enrollments()
            ->with(['section.course', 'section.course.department'])
            ->where('status', 'completed')
            ->get()
            ->groupBy(function ($item) {
                return $item->academic_year . ' - ' . $item->semester;
            })
            ->map(function ($semesterEnrollments) {
                $totalCredits = 0;
                $totalGradePoints = 0;
                
                $courses = $semesterEnrollments->map(function ($enrollment) use (&$totalCredits, &$totalGradePoints) {
                    $credits = $enrollment->section->course->credits;
                    $totalCredits += $credits;
                    
                    // Calculate grade points based on the grade
                    $gradePoints = 0;
                    switch ($enrollment->grade) {
                        case 'A': $gradePoints = 4.0; break;
                        case 'A-': $gradePoints = 3.7; break;
                        case 'B+': $gradePoints = 3.3; break;
                        case 'B': $gradePoints = 3.0; break;
                        case 'B-': $gradePoints = 2.7; break;
                        case 'C+': $gradePoints = 2.3; break;
                        case 'C': $gradePoints = 2.0; break;
                        case 'C-': $gradePoints = 1.7; break;
                        case 'D+': $gradePoints = 1.3; break;
                        case 'D': $gradePoints = 1.0; break;
                        case 'F': $gradePoints = 0.0; break;
                    }
                    
                    $totalGradePoints += ($credits * $gradePoints);
                    
                    return [
                        'enrollment_id' => $enrollment->id,
                        'course_code' => $enrollment->section->course->code,
                        'course_title' => $enrollment->section->course->title,
                        'credits' => $credits,
                        'grade' => $enrollment->grade,
                        'grade_points' => $gradePoints,
                        'department' => $enrollment->section->course->department->name,
                    ];
                });
                
                // Calculate GPA for this semester
                $semesterGPA = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;
                
                return [
                    'courses' => $courses,
                    'total_credits' => $totalCredits,
                    'semester_gpa' => $semesterGPA,
                ];
            });
        
        // Calculate cumulative GPA
        $totalCredits = 0;
        $totalGradePoints = 0;
        
        foreach ($academicHistory as $semester) {
            $totalCredits += $semester['total_credits'];
            $totalGradePoints += ($semester['total_credits'] * $semester['semester_gpa']);
        }
        
        $cumulativeGPA = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;
        
        return response()->json([
            'success' => true,
            'data' => [
                'student' => [
                    'id' => $student->id,
                    'name' => $student->user->name,
                    'student_id' => $student->student_id,
                    'department' => $student->department->name,
                    'program' => $student->program,
                    'entry_year' => $student->entry_year,
                    'academic_standing' => $student->academic_standing,
                ],
                'cumulative_gpa' => $cumulativeGPA,
                'total_credits_earned' => $totalCredits,
                'academic_history' => $academicHistory,
            ],
            'message' => 'Academic history retrieved successfully'
        ]);
    }

    /**
     * Get a student's holds.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getHolds(int $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        $holds = $student->holds()->with('createdBy')->get();
        
        return response()->json([
            'success' => true,
            'data' => $holds,
            'message' => 'Student holds retrieved successfully'
        ]);
    }

    /**
     * Add a hold to a student's account.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function addHold(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|string|in:financial,academic,disciplinary,administrative',
            'reason' => 'required|string|max:255',
            'effective_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:effective_date',
        ]);
        
        try {
            $student = Student::findOrFail($id);
            
            $hold = $student->holds()->create([
                'type' => $request->input('type'),
                'reason' => $request->input('reason'),
                'effective_date' => $request->input('effective_date'),
                'expiration_date' => $request->input('expiration_date'),
                'is_active' => true,
                'created_by' => auth()->id(),
            ]);
            
            // Load created by user data
            $hold->load('createdBy');
            
            return response()->json([
                'success' => true,
                'data' => $hold,
                'message' => 'Hold added to student successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove a hold from a student's account.
     *
     * @param int $studentId
     * @param int $holdId
     * @param Request $request
     * @return JsonResponse
     */
    public function removeHold(int $studentId, int $holdId, Request $request): JsonResponse
    {
        $request->validate([
            'removal_reason' => 'required|string|max:255',
        ]);
        
        try {
            $student = Student::findOrFail($studentId);
            
            $hold = $student->holds()->findOrFail($holdId);
            
            if (!$hold->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'This hold is already inactive'
                ], 400);
            }
            
            $hold->update([
                'is_active' => false,
                'removal_reason' => $request->input('removal_reason'),
                'removed_by' => auth()->id(),
                'removed_at' => now(),
            ]);
            
            // Load relationships
            $hold->load(['createdBy', 'removedBy']);
            
            return response()->json([
                'success' => true,
                'data' => $hold,
                'message' => 'Hold removed from student successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getProfile()
    {
        $student = auth()->user()->student;
        return response()->json($student);
    }

    public function getCourses()
    {
        $enrollments = auth()->user()->student->enrollments()
            ->with(['section.course', 'section.instructor'])
            ->where('status', 'active')
            ->get()
            ->map(function($enrollment) {
                $course = $enrollment->section->course;
                return [
                    'id' => $course->id,
                    'code' => $course->code,
                    'name' => $course->title,
                    'instructor' => $enrollment->section->instructor->name,
                    'credits' => $course->credits,
                    'department' => $course->department->name,
                    'schedule' => [
                        'days' => str_split($enrollment->section->days),
                        'startTime' => $enrollment->section->start_time,
                        'endTime' => $enrollment->section->end_time,
                        'location' => $enrollment->section->room
                    ],
                    'enrolled' => true
                ];
            });

        return response()->json($enrollments);
    }

    public function getGrades()
    {
        $grades = auth()->user()->student->enrollments()
            ->with(['course', 'grades'])
            ->get()
            ->map(function($enrollment) {
                return [
                    'courseId' => $enrollment->course->id,
                    'courseName' => $enrollment->course->title,
                    'courseCode' => $enrollment->course->code,
                    'grade' => $enrollment->grades->first()?->grade ?? 'N/A',
                    'credits' => $enrollment->course->credits,
                    'semester' => $enrollment->semester,
                    'year' => $enrollment->academic_year
                ];
            });

        return response()->json($grades);
    }

    public function getAttendance()
    {
        $attendance = auth()->user()->student->enrollments()
            ->with(['section.course', 'attendances'])
            ->get()
            ->flatMap(function($enrollment) {
                return $enrollment->attendances->map(function($attendance) use ($enrollment) {
                    return [
                        'courseId' => $enrollment->course->id,
                        'courseName' => $enrollment->course->title,
                        'courseCode' => $enrollment->course->code,
                        'date' => $attendance->date,
                        'status' => $attendance->status
                    ];
                });
            });

        return response()->json($attendance);
    }

    public function getDocuments()
    {
        $documents = auth()->user()->student->documents()
            ->get()
            ->map(function($document) {
                return [
                    'id' => $document->id,
                    'name' => $document->name,
                    'type' => $document->type,
                    'uploadDate' => $document->created_at->format('Y-m-d'),
                    'size' => $document->size,
                    'url' => $document->url
                ];
            });

        return response()->json($documents);
    }

    public function getFinancialRecords()
    {
        $records = auth()->user()->student->financialRecords()
            ->get()
            ->map(function($record) {
                return [
                    'id' => $record->id,
                    'type' => $record->type,
                    'amount' => $record->amount,
                    'date' => $record->date->format('Y-m-d'),
                    'semester' => $record->semester,
                    'year' => $record->year,
                    'status' => $record->status,
                    'description' => $record->description
                ];
            });

        return response()->json($records);
    }
}
