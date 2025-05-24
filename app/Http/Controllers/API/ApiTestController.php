<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use App\Models\Program;
use App\Models\ApplicationStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApiTestController extends Controller
{
    /**
     * Get system statistics for dashboard
     * 
     * @return JsonResponse
     */
    public function getSystemStats(): JsonResponse
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'total_departments' => Department::count(),
            'total_programs' => Program::count(),
            'total_applications' => DB::table('applications')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'system_status' => $this->getSystemStatus(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'message' => 'System statistics retrieved successfully'
        ]);
    }

    /**
     * Get current application statistics
     * 
     * @return JsonResponse
     */
    public function getApplicationStats(): JsonResponse
    {
        $pendingCount = DB::table('applications')->where('status', 'pending')->count();
        $approvedCount = DB::table('applications')->where('status', 'approved')->count();
        $rejectedCount = DB::table('applications')->where('status', 'rejected')->count();
        $totalCount = $pendingCount + $approvedCount + $rejectedCount;

        $stats = [
            'pending' => $pendingCount,
            'approved' => $approvedCount,
            'rejected' => $rejectedCount,
            'total' => $totalCount,
            'recent_applications' => DB::table('applications')
                ->select('id', 'name', 'email', 'program', 'status', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'message' => 'Application statistics retrieved successfully'
        ]);
    }

    /**
     * Get a simple health check of the system
     * 
     * @return array
     */
    private function getSystemStatus(): array
    {
        return [
            'database' => $this->checkDatabaseConnection(),
            'disk_usage' => $this->getDiskUsage(),
            'memory_usage' => $this->getMemoryUsage(),
            'server_load' => $this->getServerLoad()
        ];
    }

    /**
     * Check database connection
     * 
     * @return array
     */
    private function checkDatabaseConnection(): array
    {
        try {
            DB::connection()->getPdo();
            return [
                'status' => 'ok',
                'message' => 'Database connection successful',
                'connection' => config('database.default'),
                'database_name' => config('database.connections.' . config('database.default') . '.database')
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get disk usage information
     * 
     * @return array
     */
    private function getDiskUsage(): array
    {
        $totalSpace = disk_total_space(base_path());
        $freeSpace = disk_free_space(base_path());
        $usedSpace = $totalSpace - $freeSpace;
        $usedPercentage = round(($usedSpace / $totalSpace) * 100, 2);

        return [
            'total' => $this->formatBytes($totalSpace),
            'used' => $this->formatBytes($usedSpace),
            'free' => $this->formatBytes($freeSpace),
            'used_percentage' => $usedPercentage
        ];
    }

    /**
     * Format bytes to human-readable format
     * 
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Get memory usage
     * 
     * @return array
     */
    private function getMemoryUsage(): array
    {
        $memoryUsage = memory_get_usage(true);
        $peakMemoryUsage = memory_get_peak_usage(true);

        return [
            'current' => $this->formatBytes($memoryUsage),
            'peak' => $this->formatBytes($peakMemoryUsage)
        ];
    }

    /**
     * Get server load
     * 
     * @return array
     */
    private function getServerLoad(): array
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return [
                'last_1_minute' => $load[0],
                'last_5_minutes' => $load[1],
                'last_15_minutes' => $load[2]
            ];
        }

        return [
            'status' => 'unavailable',
            'message' => 'Server load information is not available on this system'
        ];
    }
}
