<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\SettingsController;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

if (!function_exists('formatFileSize')) {
    function formatFileSize($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
})->name('home');


// Student routes
Route::resource('students', StudentsController::class);


// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Google OAuth routes
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('google.login')->middleware('throttle:60,1');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->middleware('throttle:60,1');

// GitHub OAuth routes
Route::get('auth/github', [LoginController::class, 'redirectToGithub'])->name('github.login')->middleware('throttle:60,1');
Route::get('auth/github/callback', [LoginController::class, 'handleGithubCallback'])->middleware('throttle:60,1');

// LinkedIn OAuth routes
Route::get('auth/linkedin', [LoginController::class, 'redirectToLinkedin'])->name('linkedin.login')->middleware('throttle:60,1');
Route::get('auth/linkedin/callback', [LoginController::class, 'handleLinkedinCallback'])->middleware('throttle:60,1');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'doRegister'])->name('register.post');
Route::get('/verify', [RegisterController::class, 'verify'])->name('verify');

// Move logout route inside auth middleware group
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Password reset routes
Route::get('/password/forgot', [RegisterController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->middleware('throttle:5,1')->name('password.email');
Route::get('/password/reset', [RegisterController::class, 'showResetLink'])->name('ShowRestForm');
Route::get('/password/reset/{token}', [RegisterController::class, 'showResetLink'])->name('password.reset');
Route::post('/password/reset', [RegisterController::class, 'resetPassword'])->middleware('throttle:5,1')->name('password.update');

// Email verification routes
Route::get('/email/verify', [\App\Http\Controllers\Auth\VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

Route::post('/email/verify', [\App\Http\Controllers\Auth\VerificationController::class, 'verify'])
    ->middleware('auth')
    ->name('verification.verify');

Route::post('/email/verification-notification', [\App\Http\Controllers\Auth\VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Protected routes that require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');

    // Pages from the design
    Route::get('/courses', function () {
        return view('courses.index');
    })->name('courses.index');

    Route::get('/grades', function () {
        return view('grades.index');
    })->name('grades.index');

    Route::get('/schedule', function () {
        return view('schedule.index');
    })->name('schedule.index');

    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? 'Notification',
                'message' => $notification->data['message'] ?? '',
                'type' => $notification->data['type'] ?? 'info',
                'is_read' => $notification->read_at !== null,
                'created_at' => $notification->created_at->format('M d, Y h:i A'),
            ];
        });
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'All notifications marked as read');
    })->name('notifications.mark-all-read');

    Route::get('/financial', function () {
        $student = auth()->user()->student;
        $financialRecords = $student ? $student->financialRecords()->orderByDesc('created_at')->get() : collect();
        $currentBalance = $student ? $student->getCurrentBalance() : 0.0;
        $totalCharges = $financialRecords->where('amount', '>', 0)->sum('amount');
        $totalCredits = $financialRecords->where('amount', '<', 0)->sum('amount');

        return view('financial.index', [
            'financialRecords' => $financialRecords,
            'currentBalance' => $currentBalance,
            'totalCharges' => $totalCharges,
            'totalCredits' => $totalCredits,
        ]);
    })->name('financial.index');

    Route::get('/documents', function () {
        $student = auth()->user()->student;
        $documents = $student ? $student->documents()->latest()->get() : collect();
        return view('documents.index', compact('documents'));
    })->name('documents.index');

    Route::post('/documents/upload', function (Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:transcript,form,certificate',
            'document' => 'required|file|max:10240', // 10MB max
        ]);

        $student = auth()->user()->student;
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $file = $request->file('document');
        $path = $file->store('documents', 'public');
        
        $document = $student->documents()->create([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
            'file_size' => formatFileSize($file->getSize()),
            'uploaded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    })->name('documents.upload');

    Route::delete('/documents/{document}', function (Document $document) {
        if ($document->student_id !== auth()->user()->student->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->back()->with('success', 'Document deleted successfully.');
    })->name('documents.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.profile');
    Route::get('/settings/security', [SettingsController::class, 'security'])->name('settings.security');
    Route::get('/settings/preferences', [SettingsController::class, 'preferences'])->name('settings.preferences');
    
    // Form submission routes
    Route::put('/profile', function (Request $request) {
        $validated = $request->validate([
            'student_id' => 'required|string|max:20|unique:students,student_id,' . (auth()->user()->student->id ?? 'NULL') . ',id',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'emergency_contact' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'program' => 'required|string|max:100',
            'admission_date' => 'required|date',
        ]);

        // Set default level based on program
        $level = 'Freshman'; // Default level
        if (str_contains(strtolower($validated['program']), 'master')) {
            $level = 'Graduate';
        } elseif (str_contains(strtolower($validated['program']), 'phd')) {
            $level = 'Doctoral';
        }

        if (!auth()->user()->student) {
            // Create new student profile
            auth()->user()->student()->create(array_merge($validated, [
                'level' => $level,
                'credits_completed' => 0,
                'gpa' => 0.00,
                'academic_standing' => 'Good',
                'financial_hold' => false,
                'academic_hold' => false,
                'expected_graduation_date' => now()->addYears(4),
            ]));
        } else {
            // Update existing student profile
            auth()->user()->student->update($validated);
        }

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    })->name('profile.update');
    Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
    Route::put('/2fa/toggle', [SettingsController::class, 'toggle2FA'])->name('2fa.toggle');
    Route::delete('/sessions/{session}', [SettingsController::class, 'destroySession'])->name('sessions.destroy');
    Route::put('/preferences', [SettingsController::class, 'updatePreferences'])->name('preferences.update');


    Route::get('/profile/edit', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // Other protected routes...
    Route::get('/personal-info', function () {
        return view('personal-info');
    });

    // Sidebar navigation routes
    Route::get('/mess-info', function () {
        return redirect('/dashboard')->with('info', 'Mess Info page is under development');
    });

    Route::get('/academics', function () {
        return redirect('/dashboard')->with('info', 'Academics page is under development');
    });

    Route::get('/clubs', function () {
        return redirect('/dashboard')->with('info', 'Clubs page is under development');
    });

    Route::get('/achievements', function () {
        return redirect('/dashboard')->with('info', 'Achievements page is under development');
    });

    Route::get('/research', function () {
        return redirect('/dashboard')->with('info', 'Research work page is under development');
    });

    Route::get('/internships', function () {
        return redirect('/dashboard')->with('info', 'Internships page is under development');
    });

    Route::get('/skills', function () {
        return redirect('/dashboard')->with('info', 'Skills page is under development');
    });

    Route::get('/projects', function () {
        return redirect('/dashboard')->with('info', 'Projects page is under development');
    });

    // Course instructors routes
    Route::get('/instructors', function () {
        return redirect('/dashboard')->with('info', 'Course Instructors page is under development');
    });

    // Notices routes
    Route::get('/notices', function () {
        return redirect('/dashboard')->with('info', 'Notices page is under development');
    });

    Route::get('/notices/payment', function () {
        return redirect('/dashboard')->with('info', 'Payment details page is under development');
    });

    Route::get('/notices/exams', function () {
        return redirect('/dashboard')->with('info', 'Exam schedule page is under development');
    });

    // Course routes - No middleware, directly accessible
    Route::get('/courses', [App\Http\Controllers\Web\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [App\Http\Controllers\Web\CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [App\Http\Controllers\Web\CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [App\Http\Controllers\Web\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [App\Http\Controllers\Web\CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [App\Http\Controllers\Web\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [App\Http\Controllers\Web\CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('/courses/{course}/students', [App\Http\Controllers\Web\CourseController::class, 'students'])->name('courses.students');
    Route::get('/courses/{course}/grades', [App\Http\Controllers\Web\CourseController::class, 'grades'])->name('courses.grades');
    Route::get('/courses/{course}/schedule', [App\Http\Controllers\Web\CourseController::class, 'schedule'])->name('courses.schedule');

    // Search route
    Route::get('/search', function () {
        $query = request('query');

        // Filter results based on search query
        $filteredResults = array_filter($results, function($item) use ($query) {
            return stripos($item['title'], $query) !== false ||
                   stripos($item['description'], $query) !== false;
        });

        return view('search', [
            'query' => $query,
            'results' => $filteredResults
        ]);
    })->name('search');

    Route::post('/enrollments', [App\Http\Controllers\Web\EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::post('/enrollments/{enrollment}/approve', [App\Http\Controllers\Web\EnrollmentController::class, 'approve'])->name('enrollments.approve');
    Route::post('/enrollments/{enrollment}/reject', [App\Http\Controllers\Web\EnrollmentController::class, 'reject'])->name('enrollments.reject');
});

// Admin routes
Route::get('/admin/login', [App\Http\Controllers\AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'login'])->name('admin.login.post');

Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');

    // User management routes
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'showUsers'])->name('users');
    Route::get('/users/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');

    // New members page route
    Route::get('/members', function () {
        return view('admin.members');
    })->name('members');
});


    
Route::resource('users', \App\Http\Controllers\Web\UserController::class);
Route::get('users/{user}/profile', [\App\Http\Controllers\Web\UserController::class, 'profile'])->name('users.profile');
Route::put('users/{user}/profile', [\App\Http\Controllers\Web\UserController::class, 'updateProfile'])->name('users.profile.update');

// Role routes
Route::resource('roles', \App\Http\Controllers\Web\RoleController::class);
Route::get('roles/{role}/permissions', [\App\Http\Controllers\Web\RoleController::class, 'permissions'])->name('roles.permissions');
Route::put('roles/{role}/permissions', [\App\Http\Controllers\Web\RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

// Student routes
Route::resource('students', \App\Http\Controllers\Web\StudentController::class);
Route::get('students/{student}/courses', [\App\Http\Controllers\Web\StudentController::class, 'courses'])->name('students.courses');
Route::get('students/{student}/grades', [\App\Http\Controllers\Web\StudentController::class, 'grades'])->name('students.grades');

// Professor routes
Route::resource('professors', \App\Http\Controllers\Web\ProfessorController::class);
Route::get('professors/{professor}/courses', [\App\Http\Controllers\Web\ProfessorController::class, 'courses'])->name('professors.courses');

// Teaching Assistant routes
Route::resource('teaching-assistants', \App\Http\Controllers\Web\TeachingAssistantController::class);
Route::get('teaching-assistants/{teachingAssistant}/courses', [\App\Http\Controllers\Web\TeachingAssistantController::class, 'courses'])->name('teaching-assistants.courses');

// Admission Officer routes
Route::resource('admission-officers', \App\Http\Controllers\Web\AdmissionOfficerController::class);
Route::get('admission-officers/applications', [\App\Http\Controllers\Web\AdmissionOfficerController::class, 'applications'])->name('admission-officers.applications');

// IT Support routes
Route::resource('it-support', \App\Http\Controllers\Web\ITSupportController::class);
Route::get('it-support/tickets', [\App\Http\Controllers\Web\ITSupportController::class, 'tickets'])->name('it-support.tickets');
Route::post('it-support/tickets', [\App\Http\Controllers\Web\ITSupportController::class, 'storeTicket'])->name('it-support.tickets.store');

// Enrollment routes
Route::resource('enrollments', \App\Http\Controllers\Web\EnrollmentController::class);
Route::post('enrollments/{enrollment}/approve', [\App\Http\Controllers\Web\EnrollmentController::class, 'approve'])->name('enrollments.approve');
Route::post('enrollments/{enrollment}/reject', [\App\Http\Controllers\Web\EnrollmentController::class, 'reject'])->name('enrollments.reject');

// Grade routes
Route::resource('grades', \App\Http\Controllers\Web\GradeController::class);
Route::get('grades/statistics', [\App\Http\Controllers\Web\GradeController::class, 'statistics'])->name('grades.statistics');
Route::get('grades/report', [\App\Http\Controllers\Web\GradeController::class, 'report'])->name('grades.report');

// Notifications route
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications;
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');
});

