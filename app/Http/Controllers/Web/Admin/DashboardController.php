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
        $this->middleware(['auth', 'role:admin|registrar|faculty']);
    }
    
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }
    
    /**
     * Display the system information page.
     *
     * @return \Illuminate\Http\Response
     */
    public function systemInfo()
    {
        // Verify admin role
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to access system information.');
        }
        
        return view('admin.dashboard.system-info');
    }
    
    /**
     * Display the calendar overview.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        return view('admin.dashboard.calendar');
    }
    
    /**
     * Display activity logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function activityLogs()
    {
        // Verify admin role
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to access activity logs.');
        }
        
        return view('admin.dashboard.activity-logs');
    }
}
