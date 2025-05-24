<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\EnrollmentController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\API\FinancialRecordController;
use App\Http\Controllers\API\PaymentPlanController;
use App\Http\Controllers\API\ScholarshipController;
use App\Http\Controllers\API\StudentRequestController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\AcademicTermController;
use App\Http\Controllers\API\AcademicCalendarController;
use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\ExamResultController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ProgramController;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\DepartmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::get('/greeting', function () {
    return response()->json(['message' => 'Hello from Laravel!']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/email/verify', [AuthController::class, 'verifyEmail']);
    Route::post('/email/resend-verification', [AuthController::class, 'resendVerificationCode']);
    
    // Courses
    Route::middleware(['permission:view-course'])->group(function () {
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{course}', [CourseController::class, 'show']);
        Route::get('/courses/{course}/sections', [CourseController::class, 'getCourseSections']);
        Route::get('/courses/{course}/prerequisites', [CourseController::class, 'getCoursePrerequisites']);
        Route::get('/courses/{course}/available-sections', [CourseController::class, 'getAvailableSections']);
        Route::get('/courses/departments', [CourseController::class, 'getDepartments']);
    });

    Route::middleware(['permission:manage-course'])->group(function () {
        Route::post('/courses', [CourseController::class, 'store']);
        Route::put('/courses/{course}', [CourseController::class, 'update']);
        Route::delete('/courses/{course}', [CourseController::class, 'destroy']);
    });
    
    // Sections
    Route::apiResource('sections', SectionController::class);
    Route::get('/courses/{course}/sections', [SectionController::class, 'courseSections']);
    Route::get('/sections/{section}/capacity', [SectionController::class, 'checkCapacity']);
    
    // Enrollments
    Route::apiResource('enrollments', EnrollmentController::class);
    Route::get('/students/{student}/enrollments', [EnrollmentController::class, 'studentEnrollments']);
    Route::get('/sections/{section}/enrollments', [EnrollmentController::class, 'sectionEnrollments']);
    Route::get('/enrollments/check-conflict', [EnrollmentController::class, 'checkScheduleConflicts']);
    
    // Students
    Route::apiResource('students', StudentController::class);
    Route::get('/students/{student}/academic-history', [StudentController::class, 'academicHistory']);
    Route::get('/students/{student}/holds', [StudentController::class, 'holds']);
    Route::get('/students/search', [StudentController::class, 'search']);
    
    // Departments
    Route::apiResource('departments', DepartmentController::class);
    Route::get('/departments/{department}/courses', [DepartmentController::class, 'courses']);
    Route::get('/departments/{department}/faculty', [DepartmentController::class, 'faculty']);
    Route::get('/faculties/{faculty}/departments', [DepartmentController::class, 'facultyDepartments']);
    Route::get('/departments/faculties/list', [DepartmentController::class, 'getFaculties']);
    
    // Financial records
    Route::apiResource('financial-records', FinancialRecordController::class);
    Route::post('/financial-records/process-payment', [FinancialRecordController::class, 'processPayment']);
    Route::get('/students/{student}/financial-records', [FinancialRecordController::class, 'studentFinancialRecords']);
    
    // Payment plans
    Route::apiResource('payment-plans', PaymentPlanController::class);
    Route::get('/students/{student}/payment-plans', [PaymentPlanController::class, 'studentPaymentPlans']);
    
    // Scholarships
    Route::apiResource('scholarships', ScholarshipController::class);
    Route::get('/students/{student}/scholarships', [ScholarshipController::class, 'studentScholarships']);
    
    // Student requests
    Route::apiResource('student-requests', StudentRequestController::class);
    Route::get('/students/{student}/requests', [StudentRequestController::class, 'studentRequests']);
    
    // Attendance
    Route::apiResource('attendance', AttendanceController::class);
    Route::post('/attendance/record', [AttendanceController::class, 'recordAttendance']);
    Route::get('/students/{student}/attendance', [AttendanceController::class, 'studentAttendance']);
    Route::get('/sections/{section}/attendance', [AttendanceController::class, 'sectionAttendance']);
    Route::get('/students/{student}/attendance/stats', [AttendanceController::class, 'studentAttendanceStats']);
    Route::get('/sections/{section}/attendance/stats', [AttendanceController::class, 'sectionAttendanceStats']);

    // Academic Terms
    Route::apiResource('academic-terms', AcademicTermController::class);
    Route::get('/academic-terms/current', [AcademicTermController::class, 'getCurrentTerm']);
    Route::get('/academic-terms/registration', [AcademicTermController::class, 'getRegistrationTerms']);
    
    // Academic Calendar
    Route::apiResource('academic-calendars', AcademicCalendarController::class);
    Route::get('/academic-calendars/upcoming', [AcademicCalendarController::class, 'upcoming']);
    Route::get('/academic-calendars/{year}/{month}', [AcademicCalendarController::class, 'byMonth']);
    
    // Programs
    Route::apiResource('programs', ProgramController::class);
    Route::get('/programs/{program}/courses', [ProgramController::class, 'courses']);
    Route::get('/programs/{program}/requirements', [ProgramController::class, 'requirements']);
    Route::get('/programs/{program}/students', [ProgramController::class, 'students']);
    
    // Exams
    Route::apiResource('exams', ExamController::class);
    Route::post('/exams/{id}/publish', [ExamController::class, 'publish']);
    Route::post('/exams/{id}/unpublish', [ExamController::class, 'unpublish']);
    Route::get('/exams/{id}/eligible-students', [ExamController::class, 'getEligibleStudents']);
    Route::get('/exams/upcoming', [ExamController::class, 'upcomingExams']);
    Route::get('/exams/past', [ExamController::class, 'pastExams']);
    
    // Exam Results
    Route::get('/exams/{examId}/results', [ExamResultController::class, 'index']);
    Route::post('/exams/{examId}/results', [ExamResultController::class, 'storeBatch']);
    Route::post('/exams/{examId}/results/{studentId}', [ExamResultController::class, 'store']);
    Route::get('/exams/{examId}/results/{studentId}', [ExamResultController::class, 'show']);
    Route::put('/exams/{examId}/results/{studentId}', [ExamResultController::class, 'update']);
    Route::delete('/exams/{examId}/results/{studentId}', [ExamResultController::class, 'destroy']);
    Route::get('/students/{studentId}/exam-results', [ExamResultController::class, 'getStudentResults']);
    Route::get('/my-exam-results', [ExamResultController::class, 'getMyResults']);
    
    // Messages
    Route::get('/messages', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::get('/messages/{id}', [MessageController::class, 'show']);
    Route::post('/messages/{id}/read', [MessageController::class, 'markAsRead']);
    Route::post('/messages/{id}/unread', [MessageController::class, 'markAsUnread']);
    Route::post('/messages/{id}/star', [MessageController::class, 'toggleStar']);
    Route::post('/messages/{id}/archive', [MessageController::class, 'archive']);
    Route::post('/messages/{id}/unarchive', [MessageController::class, 'unarchive']);
    Route::delete('/messages/{id}', [MessageController::class, 'delete']);
    Route::get('/messages/unread-count', [MessageController::class, 'unreadCount']);
    Route::get('/messages/{messageId}/attachments/{attachmentId}', [MessageController::class, 'downloadAttachment']);
    
    // Announcements
    Route::apiResource('announcements', AnnouncementController::class);
    Route::get('/announcements/public', [AnnouncementController::class, 'getPublicAnnouncements']);
    Route::get('/announcements/my', [AnnouncementController::class, 'getMyAnnouncements']);

    // Student API Routes
    Route::prefix('student')->group(function () {
        Route::get('/profile', [StudentController::class, 'getProfile']);
        Route::get('/courses', [StudentController::class, 'getCourses']);
        Route::get('/grades', [StudentController::class, 'getGrades']);
        Route::get('/attendance', [StudentController::class, 'getAttendance']);
        Route::get('/documents', [StudentController::class, 'getDocuments']);
        Route::get('/financial-records', [StudentController::class, 'getFinancialRecords']);
    });
    
    // Admin API Routes - Protected with roles middleware
    Route::prefix('admin')->middleware(['role:admin|registrar|faculty'])->group(function () {
        // Dashboard routes
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
        Route::get('/dashboard/system-info', [\App\Http\Controllers\Admin\DashboardController::class, 'systemInfo']);
        Route::get('/dashboard/calendar', [\App\Http\Controllers\Admin\DashboardController::class, 'calendar']);
        Route::get('/dashboard/activity-logs', [\App\Http\Controllers\Admin\DashboardController::class, 'activityLogs']);
        
        // Academic Terms Management (Admin & Registrar only)
        Route::middleware(['role:admin|registrar'])->group(function () {
            Route::apiResource('academic-terms', \App\Http\Controllers\Admin\AcademicTermController::class);
        });
        
        // Academic Calendar Management (Admin & Registrar only)
        Route::middleware(['role:admin|registrar'])->group(function () {
            Route::apiResource('academic-calendars', \App\Http\Controllers\Admin\AcademicCalendarController::class);
            Route::get('/academic-calendars/month/{year}/{month}', [\App\Http\Controllers\Admin\AcademicCalendarController::class, 'monthView']);
            Route::get('/academic-calendars/bulk-create', [\App\Http\Controllers\Admin\AcademicCalendarController::class, 'bulkCreate']);
            Route::post('/academic-calendars/bulk-store', [\App\Http\Controllers\Admin\AcademicCalendarController::class, 'bulkStore']);
        });
        
        // Program Management (Admin & Registrar only)
        Route::middleware(['role:admin|registrar'])->group(function () {
            Route::apiResource('programs', \App\Http\Controllers\Admin\ProgramController::class);
            Route::get('/programs/{program}/manage-requirements', [\App\Http\Controllers\Admin\ProgramController::class, 'manageRequirements']);
            Route::post('/programs/{program}/requirements', [\App\Http\Controllers\Admin\ProgramController::class, 'storeRequirements']);
            Route::get('/programs/{program}/manage-prerequisites', [\App\Http\Controllers\Admin\ProgramController::class, 'managePrerequisites']);
            Route::post('/programs/{program}/prerequisites', [\App\Http\Controllers\Admin\ProgramController::class, 'storePrerequisites']);
            Route::get('/programs/{program}/export-pdf', [\App\Http\Controllers\Admin\ProgramController::class, 'exportPdf']);
            Route::get('/programs/{program}/export-excel', [\App\Http\Controllers\Admin\ProgramController::class, 'exportExcel']);
            Route::post('/programs/import', [\App\Http\Controllers\Admin\ProgramController::class, 'import']);
        });
        
        // Exam Management (Admin & Faculty)
        Route::apiResource('exams', \App\Http\Controllers\Admin\ExamController::class);
        Route::post('/exams/{exam}/publish', [\App\Http\Controllers\Admin\ExamController::class, 'publish']);
        Route::post('/exams/{exam}/unpublish', [\App\Http\Controllers\Admin\ExamController::class, 'unpublish']);
        Route::get('/exams/{exam}/record-results', [\App\Http\Controllers\Admin\ExamController::class, 'recordResults']);
        Route::post('/exams/{exam}/store-results', [\App\Http\Controllers\Admin\ExamController::class, 'storeResults']);
        
        // Exam Results Management (Admin & Faculty)
        Route::apiResource('exam-results', \App\Http\Controllers\Admin\ExamResultController::class);
        Route::get('/exam-results/import', [\App\Http\Controllers\Admin\ExamResultController::class, 'importForm']);
        Route::post('/exam-results/import', [\App\Http\Controllers\Admin\ExamResultController::class, 'importProcess']);
        Route::get('/exam-results/template', [\App\Http\Controllers\Admin\ExamResultController::class, 'downloadTemplate']);
    });
});

// Social Login Routes
Route::get('auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.login');
Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback']);

// Link/Unlink Social Accounts (Protected)
Route::middleware('auth:api')->group(function () {
    Route::get('/social-accounts', [SocialAuthController::class, 'getSocialAccounts']);
    Route::post('/link/{provider}', [SocialAuthController::class, 'linkAccount']);
    Route::delete('/unlink/{provider}', [SocialAuthController::class, 'unlinkAccount']);
});

// Student Application Routes
Route::middleware('auth:api')->group(function () {
    // Student application endpoints
    Route::get('/applications', [\App\Http\Controllers\API\ApplicationController::class, 'index']);
    Route::post('/applications', [\App\Http\Controllers\API\ApplicationController::class, 'store']);
    Route::get('/applications/{id}', [\App\Http\Controllers\API\ApplicationController::class, 'show']);
    
    // Admin/Admissions application management endpoints
    Route::middleware(['role:admin|admissions'])->group(function () {
        Route::put('/applications/{id}', [\App\Http\Controllers\API\ApplicationController::class, 'update']);
        Route::get('/applications/statistics', [\App\Http\Controllers\API\ApplicationController::class, 'statistics']);
    });
});


// Fallback route for undefined API routes
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
