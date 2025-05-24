<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicCalendarController extends Controller
{
    /**
     * Display a listing of the academic calendar events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = AcademicCalendar::with('term')
            ->orderBy('start_date')
            ->paginate(15);
            
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('academic-calendar.index', compact('events', 'terms'));
    }

    /**
     * Show the form for creating a new calendar event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('academic-calendar.create', compact('terms'));
    }

    /**
     * Store a newly created calendar event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:class,exam,holiday,event,deadline',
            'academic_term_id' => 'required|exists:academic_terms,id',
        ]);
        
        AcademicCalendar::create($validated);
        
        return redirect()->route('academic-calendar.index')
            ->with('success', 'Calendar event created successfully.');
    }

    /**
     * Display the specified calendar event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = AcademicCalendar::with('term')->findOrFail($id);
        
        return view('academic-calendar.show', compact('event'));
    }

    /**
     * Show the form for editing the specified calendar event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = AcademicCalendar::findOrFail($id);
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return view('academic-calendar.edit', compact('event', 'terms'));
    }

    /**
     * Update the specified calendar event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = AcademicCalendar::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:class,exam,holiday,event,deadline',
            'academic_term_id' => 'required|exists:academic_terms,id',
        ]);
        
        $event->update($validated);
        
        return redirect()->route('academic-calendar.show', $event->id)
            ->with('success', 'Calendar event updated successfully.');
    }

    /**
     * Remove the specified calendar event from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = AcademicCalendar::findOrFail($id);
        $event->delete();
        
        return redirect()->route('academic-calendar.index')
            ->with('success', 'Calendar event deleted successfully.');
    }
    
    /**
     * Display the current academic calendar.
     *
     * @return \Illuminate\Http\Response
     */
    public function current()
    {
        $currentTerm = AcademicTerm::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
            
        if (!$currentTerm) {
            // If no current term, get the upcoming term
            $currentTerm = AcademicTerm::where('start_date', '>', now())
                ->orderBy('start_date')
                ->first();
        }
        
        $events = [];
        if ($currentTerm) {
            $events = AcademicCalendar::where('academic_term_id', $currentTerm->id)
                ->orderBy('start_date')
                ->get();
        }
        
        // Format for calendar view
        $calendarEvents = $events->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->format('Y-m-d'),
                'end' => $event->end_date->addDay()->format('Y-m-d'), // Add day for inclusive end date
                'description' => $event->description,
                'type' => $event->type,
                'className' => $this->getEventClassName($event->type),
                'url' => route('academic-calendar.show', $event->id)
            ];
        });
        
        return view('academic-calendar.current', compact('currentTerm', 'calendarEvents'));
    }
    
    /**
     * Get CSS class name for event type.
     *
     * @param  string  $type
     * @return string
     */
    private function getEventClassName($type)
    {
        $classNames = [
            'class' => 'bg-blue-200 border-blue-600',
            'exam' => 'bg-red-200 border-red-600',
            'holiday' => 'bg-green-200 border-green-600',
            'event' => 'bg-purple-200 border-purple-600',
            'deadline' => 'bg-yellow-200 border-yellow-600',
        ];
        
        return $classNames[$type] ?? 'bg-gray-200 border-gray-600';
    }
}
