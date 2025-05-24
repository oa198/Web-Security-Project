<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicCalendar;
use App\Models\AcademicTerm;
use Illuminate\Support\Facades\Auth;

class AcademicCalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|registrar']);
    }
    
    /**
     * Display a listing of calendar events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.academic-calendars.index');
    }
    
    /**
     * Show the form for creating a new calendar event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.academic-calendars.create');
    }
    
    /**
     * Display the specified calendar event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.academic-calendars.show', ['eventId' => $id]);
    }
    
    /**
     * Show the form for editing the specified calendar event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.academic-calendars.edit', ['eventId' => $id]);
    }
    
    /**
     * Display the calendar in a monthly view.
     *
     * @param  int  $year
     * @param  int  $month
     * @return \Illuminate\Http\Response
     */
    public function monthView($year = null, $month = null)
    {
        // Default to current month if not specified
        $year = $year ?? date('Y');
        $month = $month ?? date('m');
        
        return view('admin.academic-calendars.month-view', compact('year', 'month'));
    }
    
    /**
     * Show form for bulk creation of calendar events.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkCreate()
    {
        return view('admin.academic-calendars.bulk-create');
    }
}
