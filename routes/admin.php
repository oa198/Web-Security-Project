<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| These routes handle the web views for the admin dashboard and related
| functionality. They connect to the API endpoints for data operations.
|
*/

// Admin routes - protected with auth and role middleware
Route::middleware(['auth', 'verified', 'role:admin|registrar|faculty'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard routes
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/system-info', [DashboardController::class, 'systemInfo'])->name('system-info');
    Route::get('/calendar-overview', [DashboardController::class, 'calendar'])->name('calendar-overview');
    Route::get('/activity-logs', [DashboardController::class, 'activityLogs'])->name('activity-logs');
    
    // Academic Terms Management (Admin & Registrar only)
    Route::middleware(['role:admin|registrar'])->group(function () {
        Route::get('/academic-terms', [App\Http\Controllers\Web\Admin\AcademicTermController::class, 'index'])->name('academic-terms.index');
        Route::get('/academic-terms/create', [App\Http\Controllers\Web\Admin\AcademicTermController::class, 'create'])->name('academic-terms.create');
        Route::get('/academic-terms/{academicTerm}', [App\Http\Controllers\Web\Admin\AcademicTermController::class, 'show'])->name('academic-terms.show');
        Route::get('/academic-terms/{academicTerm}/edit', [App\Http\Controllers\Web\Admin\AcademicTermController::class, 'edit'])->name('academic-terms.edit');
    });
    
    // Academic Calendar Management (Admin & Registrar only)
    Route::middleware(['role:admin|registrar'])->group(function () {
        Route::get('/academic-calendars', [App\Http\Controllers\Web\Admin\AcademicCalendarController::class, 'index'])->name('academic-calendars.index');
        Route::get('/academic-calendars/create', [App\Http\Controllers\Web\Admin\AcademicCalendarController::class, 'create'])->name('academic-calendars.create');
        Route::get('/academic-calendars/month/{year}/{month}', [App\Http\Controllers\Web\Admin\AcademicCalendarController::class, 'monthView'])->name('academic-calendars.month-view');
        Route::get('/academic-calendars/bulk-create', [App\Http\Controllers\Web\Admin\AcademicCalendarController::class, 'bulkCreate'])->name('academic-calendars.bulk-create');
        Route::get('/academic-calendars/{academicCalendar}', [App\Http\Controllers\Web\Admin\AcademicCalendarController::class, 'show'])->name('academic-calendars.show');
        Route::get('/academic-calendars/{academicCalendar}/edit', [App\Http\Controllers\Web\Admin\AcademicCalendarController::class, 'edit'])->name('academic-calendars.edit');
    });
    
    // Program Management (Admin & Registrar only)
    Route::middleware(['role:admin|registrar'])->group(function () {
        Route::get('/programs', [App\Http\Controllers\Web\Admin\ProgramController::class, 'index'])->name('programs.index');
        Route::get('/programs/create', [App\Http\Controllers\Web\Admin\ProgramController::class, 'create'])->name('programs.create');
        Route::get('/programs/{program}', [App\Http\Controllers\Web\Admin\ProgramController::class, 'show'])->name('programs.show');
        Route::get('/programs/{program}/edit', [App\Http\Controllers\Web\Admin\ProgramController::class, 'edit'])->name('programs.edit');
        Route::get('/programs/{program}/manage-requirements', [App\Http\Controllers\Web\Admin\ProgramController::class, 'manageRequirements'])->name('programs.manage-requirements');
        Route::get('/programs/{program}/manage-prerequisites', [App\Http\Controllers\Web\Admin\ProgramController::class, 'managePrerequisites'])->name('programs.manage-prerequisites');
    });
    
    // Application Management (Admin & Admissions only)
    Route::middleware(['role:admin|admissions'])->group(function () {
        Route::get('/applications', [App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{id}', [App\Http\Controllers\Admin\ApplicationController::class, 'show'])->name('applications.show');
        Route::get('/applications/{id}/edit', [App\Http\Controllers\Admin\ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('/applications/{id}', [App\Http\Controllers\Admin\ApplicationController::class, 'update'])->name('applications.update');
    });
    
    // Exam Management (Admin & Faculty)
    Route::get('/exams', [App\Http\Controllers\Web\Admin\ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [App\Http\Controllers\Web\Admin\ExamController::class, 'create'])->name('exams.create');
    Route::get('/exams/{exam}', [App\Http\Controllers\Web\Admin\ExamController::class, 'show'])->name('exams.show');
    Route::get('/exams/{exam}/edit', [App\Http\Controllers\Web\Admin\ExamController::class, 'edit'])->name('exams.edit');
    Route::get('/exams/{exam}/record-results', [App\Http\Controllers\Web\Admin\ExamController::class, 'recordResults'])->name('exams.record-results');
    
    // Exam Results Management (Admin & Faculty)
    Route::get('/exam-results', [App\Http\Controllers\Web\Admin\ExamResultController::class, 'index'])->name('exam-results.index');
    Route::get('/exam-results/create', [App\Http\Controllers\Web\Admin\ExamResultController::class, 'create'])->name('exam-results.create');
    Route::get('/exam-results/import', [App\Http\Controllers\Web\Admin\ExamResultController::class, 'importForm'])->name('exam-results.import');
    Route::get('/exam-results/{examResult}', [App\Http\Controllers\Web\Admin\ExamResultController::class, 'show'])->name('exam-results.show');
    Route::get('/exam-results/{examResult}/edit', [App\Http\Controllers\Web\Admin\ExamResultController::class, 'edit'])->name('exam-results.edit');
});
