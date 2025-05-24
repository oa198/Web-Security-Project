<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Temporarily using only auth middleware
        // TODO: Re-implement role middleware once permissions are set up
        $this->middleware(['auth']);
    }
    
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get total users count for dashboard
        $totalUsers = \App\Models\User::count();
        
        // Get recent users for dashboard
        $recentUsers = \App\Models\User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalUsers', 'recentUsers'));
    }
    
    /**
     * Display the system information page.
     *
     * @return \Illuminate\Http\Response
     */
    public function systemInfo()
    {
        // Role verification temporarily disabled
        // TODO: Re-implement role check once permissions are set up
        
        // Use the main dashboard view with a different active tab
        return view('admin.dashboard', [
            'activeTab' => 'system-info',
            'totalUsers' => \App\Models\User::count(),
            'recentUsers' => \App\Models\User::latest()->take(5)->get()
        ]);
    }
    
    /**
     * Display the calendar overview.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        // Use the main dashboard view with a different active tab
        return view('admin.dashboard', [
            'activeTab' => 'calendar',
            'totalUsers' => \App\Models\User::count(),
            'recentUsers' => \App\Models\User::latest()->take(5)->get()
        ]);
    }
    
    /**
     * Display activity logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function activityLogs()
    {
        // Role verification temporarily disabled
        // TODO: Re-implement role check once permissions are set up
        
        // Use the main dashboard view with a different active tab
        return view('admin.dashboard', [
            'activeTab' => 'activity-logs',
            'totalUsers' => \App\Models\User::count(),
            'recentUsers' => \App\Models\User::latest()->take(5)->get()
        ]);
    }
}
