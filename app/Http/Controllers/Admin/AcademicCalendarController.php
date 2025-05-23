<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    {
        $query = AcademicCalendar::with('academicTerm');
        
        // Filter by term if provided
        if ($request->has('term_id')) {
            $query->where('academic_term_id', $request->term_id);
        }
        
        // Filter by event type if provided
        if ($request->has('event_type')) {
            $query->where('event_type', $request->event_type);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->inDateRange($request->start_date, $request->end_date);
        }
        
        $events = $query->orderBy('start_date')->orderBy('start_time')->paginate(15);
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('admin.academic-calendar.index', compact('events', 'terms'));
    }

    /**
     * Show the form for creating a new calendar event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('admin.academic-calendar.create', compact('terms'));
    }

    /**
     * Store a newly created calendar event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_term_id' => 'required|exists:academic_terms,id',
            'event_type' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'is_holiday' => 'boolean',
            'is_campus_closed' => 'boolean',
            'color_code' => 'nullable|string|max:20',
            'visibility' => 'required|in:public,staff,students,faculty',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        AcademicCalendar::create($request->all());

        return redirect()->route('admin.academic-calendar.index')
            ->with('success', 'Calendar event created successfully');
    }

    /**
     * Display the specified calendar event.
     *
     * @param  \App\Models\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicCalendar $academicCalendar)
    {
        $academicCalendar->load('academicTerm');
        
        return view('admin.academic-calendar.show', compact('academicCalendar'));
    }

    /**
     * Show the form for editing the specified calendar event.
     *
     * @param  \App\Models\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicCalendar $academicCalendar)
    {
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('admin.academic-calendar.edit', compact('academicCalendar', 'terms'));
    }

    /**
     * Update the specified calendar event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicCalendar $academicCalendar)
    {
        $validator = Validator::make($request->all(), [
            'academic_term_id' => 'required|exists:academic_terms,id',
            'event_type' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'is_holiday' => 'boolean',
            'is_campus_closed' => 'boolean',
            'color_code' => 'nullable|string|max:20',
            'visibility' => 'required|in:public,staff,students,faculty',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $academicCalendar->update($request->all());

        return redirect()->route('admin.academic-calendar.index')
            ->with('success', 'Calendar event updated successfully');
    }

    /**
     * Remove the specified calendar event from storage.
     *
     * @param  \App\Models\AcademicCalendar  $academicCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicCalendar $academicCalendar)
    {
        $academicCalendar->delete();
        
        return redirect()->route('admin.academic-calendar.index')
            ->with('success', 'Calendar event deleted successfully');
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
        
        // Validate year and month
        if (!is_numeric($year) || !is_numeric($month) || $month < 1 || $month > 12) {
            return redirect()->route('admin.academic-calendar.month-view');
        }
        
        // Get start and end dates for the month
        $startDate = "$year-$month-01";
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $events = AcademicCalendar::with('academicTerm')
            ->inDateRange($startDate, $endDate)
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();
            
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('admin.academic-calendar.month-view', compact('events', 'terms', 'year', 'month'));
    }

    /**
     * Bulk create calendar events.
     *
     * @return \Illuminate\Http\Response
     */
    public function bulkCreate()
    {
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('admin.academic-calendar.bulk-create', compact('terms'));
    }

    /**
     * Store multiple calendar events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_term_id' => 'required|exists:academic_terms,id',
            'events' => 'required|array|min:1',
            'events.*.event_type' => 'required|string|max:100',
            'events.*.name' => 'required|string|max:255',
            'events.*.start_date' => 'required|date',
            'events.*.end_date' => 'nullable|date|after_or_equal:events.*.start_date',
            'events.*.visibility' => 'required|in:public,staff,students,faculty',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        foreach ($request->events as $eventData) {
            $eventData['academic_term_id'] = $request->academic_term_id;
            AcademicCalendar::create($eventData);
        }

        return redirect()->route('admin.academic-calendar.index')
            ->with('success', count($request->events) . ' calendar events created successfully');
    }
}
