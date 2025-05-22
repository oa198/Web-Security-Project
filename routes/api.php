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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/email/verify', [AuthController::class, 'verifyEmail']);
    Route::post('/email/resend-verification', [AuthController::class, 'resendVerificationCode']);
    
    // Courses
    Route::apiResource('courses', CourseController::class);
    Route::get('/courses/search', [CourseController::class, 'search']);
    
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

    // Student API Routes
    Route::prefix('student')->group(function () {
        Route::get('/profile', [StudentController::class, 'getProfile']);
        Route::get('/courses', [StudentController::class, 'getCourses']);
        Route::get('/grades', [StudentController::class, 'getGrades']);
        Route::get('/attendance', [StudentController::class, 'getAttendance']);
        Route::get('/documents', [StudentController::class, 'getDocuments']);
        Route::get('/financial-records', [StudentController::class, 'getFinancialRecords']);
    });
});

// Fallback route for undefined API routes
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
