<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Program;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Message;
use App\Models\Announcement;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|registrar|faculty']);
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get key statistics based on role
        $stats = [];
        $currentTerm = AcademicTerm::where('is_active', true)->first();
        
        // Base statistics for all roles
        $stats['total_students'] = Student::count();
        $stats['total_programs'] = Program::count();
        $stats['total_courses'] = Course::count();
        
        // Get upcoming exams
        $upcomingExams = Exam::where('start_datetime', '>', now())
            ->where('start_datetime', '<', now()->addDays(14))
            ->orderBy('start_datetime')
            ->limit(5)
            ->get();
            
        // Get recent announcements
        $recentAnnouncements = Announcement::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Role-specific stats and widgets
        if (Auth::user()->hasRole('admin')) {
            // Admin-specific statistics
            $stats['total_users'] = User::count();
            $stats['verified_users'] = User::whereNotNull('email_verified_at')->count();
            $stats['total_exams'] = Exam::count();
            $stats['total_messages'] = Message::count();
            
            // User registration trends
            $userTrends = $this->getUserRegistrationTrends();
            
            // Academic term overview
            $academicTerms = AcademicTerm::orderBy('start_date', 'desc')
                ->limit(5)
                ->get();
                
            return view('admin.dashboard.admin', compact('stats', 'upcomingExams', 'recentAnnouncements', 'userTrends', 'academicTerms', 'currentTerm'));
            
        } elseif (Auth::user()->hasRole('registrar')) {
            // Registrar-specific statistics
            $stats['active_students'] = Student::where('status', 'active')->count();
            $stats['active_programs'] = Program::where('is_active', true)->count();
            
            // Program enrollment statistics
            $programEnrollments = $this->getProgramEnrollmentStats();
            
            return view('admin.dashboard.registrar', compact('stats', 'upcomingExams', 'recentAnnouncements', 'programEnrollments', 'currentTerm'));
            
        } elseif (Auth::user()->hasRole('faculty')) {
            // Faculty-specific statistics
            $facultyId = Auth::id();
            
            $stats['faculty_courses'] = Course::where('instructor_id', $facultyId)->count();
            $stats['faculty_exams'] = Exam::where('created_by', $facultyId)->count();
            
            // Get recent exam results for faculty's exams
            $recentResults = ExamResult::with(['exam', 'student.user'])
                ->whereHas('exam', function($query) use ($facultyId) {
                    $query->where('created_by', $facultyId);
                })
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
                
            // Get faculty's courses
            $facultyCourses = Course::where('instructor_id', $facultyId)
                ->with(['sections'])
                ->get();
                
            return view('admin.dashboard.faculty', compact('stats', 'upcomingExams', 'recentAnnouncements', 'recentResults', 'facultyCourses', 'currentTerm'));
        }
        
        // Default dashboard if no specific role
        return view('admin.dashboard.index', compact('stats', 'upcomingExams', 'recentAnnouncements', 'currentTerm'));
    }
    
    /**
     * Get user registration trends for the last 12 months.
     *
     * @return array
     */
    private function getUserRegistrationTrends()
    {
        $trends = [];
        
        // Get user counts by month for the last 12 months
        $userCounts = DB::table('users')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Format for chart display
        $labels = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $yearMonth = $date->format('Y-m');
            $labels[] = $date->format('M Y');
            
            $monthData = $userCounts->first(function($value) use ($date) {
                return $value->year == $date->year && $value->month == $date->month;
            });
            
            $data[] = $monthData ? $monthData->count : 0;
        }
        
        $trends['labels'] = $labels;
        $trends['data'] = $data;
        
        return $trends;
    }
    
    /**
     * Get program enrollment statistics.
     *
     * @return array
     */
    private function getProgramEnrollmentStats()
    {
        $enrollmentStats = DB::table('students')
            ->join('programs', 'students.program_id', '=', 'programs.id')
            ->select('programs.name as program_name', DB::raw('COUNT(*) as student_count'))
            ->groupBy('programs.name')
            ->orderByDesc('student_count')
            ->limit(10)
            ->get();
            
        return $enrollmentStats;
    }
    
    /**
     * Show system information for administrators.
     *
     * @return \Illuminate\Http\Response
     */
    public function systemInfo()
    {
        // Only admin can access this
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database' => DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME) . ' ' . 
                          DB::select('SELECT VERSION() as version')[0]->version,
            'environment' => app()->environment(),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'queue_driver' => config('queue.default'),
        ];
        
        // Database statistics
        $dbStats = [
            'users_count' => User::count(),
            'students_count' => Student::count(),
            'programs_count' => Program::count(),
            'courses_count' => Course::count(),
            'exams_count' => Exam::count(),
            'messages_count' => Message::count(),
            'announcements_count' => Announcement::count(),
        ];
        
        return view('admin.dashboard.system-info', compact('systemInfo', 'dbStats'));
    }
    
    /**
     * Show calendar overview.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        $currentTerm = AcademicTerm::where('is_active', true)->first();
        $calendarEvents = [];
        
        // Get academic calendar events
        if ($currentTerm) {
            $events = $currentTerm->calendarEvents()->get();
            
            foreach ($events as $event) {
                $calendarEvents[] = [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->start_date . ($event->start_time ? ' ' . $event->start_time : ''),
                    'end' => $event->end_date ? ($event->end_date . ($event->end_time ? ' ' . $event->end_time : '')) : null,
                    'color' => $event->color_code ?? '#3788d8',
                    'url' => route('admin.academic-calendar.show', $event),
                    'description' => $event->description,
                    'location' => $event->location,
                    'type' => $event->event_type,
                ];
            }
        }
        
        // Get upcoming exams
        $exams = Exam::where('start_datetime', '>', now())->get();
        
        foreach ($exams as $exam) {
            $calendarEvents[] = [
                'id' => 'exam_' . $exam->id,
                'title' => 'Exam: ' . $exam->title,
                'start' => $exam->start_datetime,
                'end' => $exam->end_datetime,
                'color' => '#dc3545', // Red for exams
                'url' => route('admin.exams.show', $exam),
                'description' => $exam->description,
                'location' => $exam->location,
                'type' => 'exam',
            ];
        }
        
        return view('admin.dashboard.calendar', compact('calendarEvents', 'currentTerm'));
    }
    
    /**
     * Show activity logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function activityLogs(Request $request)
    {
        // Only admin can access this
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        // Fetch activity logs if you have a logging system
        // This implementation assumes you're using the spatie/laravel-activitylog package
        // If not, you'll need to implement your own logging system
        
        $query = \Spatie\Activitylog\Models\Activity::query();
        
        // Filter by causer (user) if provided
        if ($request->has('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }
        
        // Filter by log name if provided
        if ($request->has('log_name')) {
            $query->where('log_name', $request->log_name);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
        }
        
        $logs = $query->orderBy('created_at', 'desc')->paginate(20);
        $users = User::orderBy('name')->get();
        
        return view('admin.dashboard.activity-logs', compact('logs', 'users'));
    }
}
