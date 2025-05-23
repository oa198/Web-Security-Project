<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AcademicCalendarController extends Controller
{
    /**
     * Display a listing of calendar events.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = AcademicCalendar::with('academicTerm');
        
        // Filter by term if provided
        if ($request->has('term_id')) {
            $query->where('academic_term_id', $request->term_id);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->inDateRange($request->start_date, $request->end_date);
        }
        
        // Filter by event type if provided
        if ($request->has('event_type')) {
            $query->where('event_type', $request->event_type);
        }
        
        // Filter by visibility if provided
        if ($request->has('visibility')) {
            $query->visibleTo($request->visibility);
        }
        
        $events = $query->orderBy('start_date')->orderBy('start_time')->get();
        
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Store a newly created calendar event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
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
            'visibility' => 'string|in:public,staff,students,faculty',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify academic term exists
        $term = AcademicTerm::findOrFail($request->academic_term_id);
        
        $event = AcademicCalendar::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Calendar event created successfully',
            'data' => $event
        ], 201);
    }

    /**
     * Display the specified calendar event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $event = AcademicCalendar::with('academicTerm')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $event
        ]);
    }

    /**
     * Update the specified calendar event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $event = AcademicCalendar::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'academic_term_id' => 'exists:academic_terms,id',
            'event_type' => 'string|max:100',
            'name' => 'string|max:255',
            'start_date' => 'date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'is_holiday' => 'boolean',
            'is_campus_closed' => 'boolean',
            'color_code' => 'nullable|string|max:20',
            'visibility' => 'string|in:public,staff,students,faculty',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $event->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Calendar event updated successfully',
            'data' => $event
        ]);
    }

    /**
     * Remove the specified calendar event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $event = AcademicCalendar::findOrFail($id);
        $event->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Calendar event deleted successfully'
        ]);
    }

    /**
     * Get upcoming events.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcoming(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $visibility = $request->input('visibility', 'public');
        
        $events = AcademicCalendar::with('academicTerm')
            ->visibleTo($visibility)
            ->where('start_date', '>=', now()->toDateString())
            ->orWhere(function($query) {
                $query->where('start_date', '<=', now()->toDateString())
                      ->where('end_date', '>=', now()->toDateString());
            })
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->limit($limit)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    /**
     * Get events by month.
     *
     * @param Request $request
     * @param string $year
     * @param string $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function byMonth(Request $request, $year, $month): JsonResponse
    {
        $visibility = $request->input('visibility', 'public');
        
        // Validate year and month
        if (!is_numeric($year) || !is_numeric($month) || $month < 1 || $month > 12) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid year or month'
            ], 400);
        }
        
        // Get start and end dates for the month
        $startDate = "$year-$month-01";
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $events = AcademicCalendar::with('academicTerm')
            ->visibleTo($visibility)
            ->inDateRange($startDate, $endDate)
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }
}
