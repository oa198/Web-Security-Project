<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AnnouncementNotification;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Announcement::with('author');
        
        // Filter by target audience if provided
        if ($request->has('target_audience')) {
            $query->where('target_audience', $request->target_audience);
        }
        
        // Filter by importance if provided
        if ($request->has('importance')) {
            $query->where('importance', $request->importance);
        }
        
        // Filter by published status if provided
        if ($request->has('is_published')) {
            $query->where('is_published', $request->boolean('is_published'));
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('publish_at', [$request->start_date, $request->end_date]);
        }
        
        $announcements = $query->orderBy('publish_at', 'desc')->paginate(15);
        
        return response()->json([
            'success' => true,
            'data' => $announcements
        ]);
    }

    /**
     * Store a newly created announcement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,students,faculty,staff,department,course,section',
            'target_id' => 'nullable|integer|required_if:target_audience,department,course,section',
            'importance' => 'required|in:low,medium,high,urgent',
            'publish_at' => 'nullable|date|after_or_equal:today',
            'expires_at' => 'nullable|date|after:publish_at',
            'is_published' => 'boolean',
            'show_on_dashboard' => 'boolean',
            'send_email' => 'boolean',
            'send_notification' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the announcement
        $announcement = new Announcement();
        $announcement->author_id = Auth::id();
        $announcement->title = $request->title;
        $announcement->content = $request->content;
        $announcement->target_audience = $request->target_audience;
        $announcement->target_id = $request->target_id;
        $announcement->importance = $request->importance;
        $announcement->publish_at = $request->publish_at ?? now();
        $announcement->expires_at = $request->expires_at;
        $announcement->is_published = $request->boolean('is_published', true);
        $announcement->show_on_dashboard = $request->boolean('show_on_dashboard', true);
        $announcement->send_email = $request->boolean('send_email', false);
        $announcement->send_notification = $request->boolean('send_notification', true);
        $announcement->save();
        
        // Send notifications if requested and announcement is published
        if ($announcement->is_published && 
            ($announcement->send_email || $announcement->send_notification)) {
            
            // Get target users
            $users = $announcement->getTargetUsers();
            
            // Send notifications
            Notification::send($users, new AnnouncementNotification($announcement));
        }

        return response()->json([
            'success' => true,
            'message' => 'Announcement created successfully',
            'data' => $announcement
        ], 201);
    }

    /**
     * Display the specified announcement.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $announcement = Announcement::with('author')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $announcement
        ]);
    }

    /**
     * Update the specified announcement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $announcement = Announcement::findOrFail($id);
        
        // Check if user is the author
        if (Auth::id() != $announcement->author_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this announcement'
            ], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'content' => 'string',
            'target_audience' => 'in:all,students,faculty,staff,department,course,section',
            'target_id' => 'nullable|integer|required_if:target_audience,department,course,section',
            'importance' => 'in:low,medium,high,urgent',
            'publish_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:publish_at',
            'is_published' => 'boolean',
            'show_on_dashboard' => 'boolean',
            'send_email' => 'boolean',
            'send_notification' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if we're changing from unpublished to published
        $wasPublished = $announcement->is_published;
        $nowPublished = $request->has('is_published') ? $request->boolean('is_published') : $wasPublished;
        $sendNotifications = !$wasPublished && $nowPublished;
        
        // Update the announcement
        if ($request->has('title')) {
            $announcement->title = $request->title;
        }
        
        if ($request->has('content')) {
            $announcement->content = $request->content;
        }
        
        if ($request->has('target_audience')) {
            $announcement->target_audience = $request->target_audience;
        }
        
        if ($request->has('target_id')) {
            $announcement->target_id = $request->target_id;
        }
        
        if ($request->has('importance')) {
            $announcement->importance = $request->importance;
        }
        
        if ($request->has('publish_at')) {
            $announcement->publish_at = $request->publish_at;
        }
        
        if ($request->has('expires_at')) {
            $announcement->expires_at = $request->expires_at;
        }
        
        if ($request->has('is_published')) {
            $announcement->is_published = $request->boolean('is_published');
        }
        
        if ($request->has('show_on_dashboard')) {
            $announcement->show_on_dashboard = $request->boolean('show_on_dashboard');
        }
        
        if ($request->has('send_email')) {
            $announcement->send_email = $request->boolean('send_email');
        }
        
        if ($request->has('send_notification')) {
            $announcement->send_notification = $request->boolean('send_notification');
        }
        
        $announcement->save();
        
        // Send notifications if the announcement just became published
        if ($sendNotifications && 
            ($announcement->send_email || $announcement->send_notification)) {
            
            // Get target users
            $users = $announcement->getTargetUsers();
            
            // Send notifications
            Notification::send($users, new AnnouncementNotification($announcement));
        }

        return response()->json([
            'success' => true,
            'message' => 'Announcement updated successfully',
            'data' => $announcement
        ]);
    }

    /**
     * Remove the specified announcement.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $announcement = Announcement::findOrFail($id);
        
        // Check if user is the author
        if (Auth::id() != $announcement->author_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this announcement'
            ], 403);
        }
        
        $announcement->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Announcement deleted successfully'
        ]);
    }

    /**
     * Get public announcements.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPublicAnnouncements(): JsonResponse
    {
        $announcements = Announcement::with('author')
            ->where('is_published', true)
            ->where('target_audience', 'all')
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->where('publish_at', '<=', now())
            ->orderBy('importance', 'desc')
            ->orderBy('publish_at', 'desc')
            ->take(10)
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => $announcements
        ]);
    }

    /**
     * Get announcements relevant to the current user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyAnnouncements(Request $request): JsonResponse
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        
        $query = Announcement::with('author')
            ->where('is_published', true)
            ->where(function($query) use ($user, $roles) {
                // Include announcements for all users
                $query->where('target_audience', 'all');
                
                // Include announcements for the user's roles
                if ($roles->contains('student')) {
                    $query->orWhere('target_audience', 'students');
                    
                    // Include department announcements
                    if ($user->student && $user->student->department_id) {
                        $query->orWhere(function($q) use ($user) {
                            $q->where('target_audience', 'department')
                              ->where('target_id', $user->student->department_id);
                        });
                    }
                    
                    // Include course announcements
                    $courseIds = $user->enrolledCourses()->pluck('courses.id')->toArray();
                    if (count($courseIds) > 0) {
                        $query->orWhere(function($q) use ($courseIds) {
                            $q->where('target_audience', 'course')
                              ->whereIn('target_id', $courseIds);
                        });
                    }
                    
                    // Include section announcements
                    $sectionIds = $user->enrolledCourses()
                        ->with('sections')
                        ->get()
                        ->pluck('sections.*.id')
                        ->flatten()
                        ->toArray();
                    if (count($sectionIds) > 0) {
                        $query->orWhere(function($q) use ($sectionIds) {
                            $q->where('target_audience', 'section')
                              ->whereIn('target_id', $sectionIds);
                        });
                    }
                }
                
                if ($roles->contains('faculty')) {
                    $query->orWhere('target_audience', 'faculty');
                    
                    // Include department announcements for faculty
                    $departmentIds = $user->taughtCourses()
                        ->with('department')
                        ->get()
                        ->pluck('department.id')
                        ->unique()
                        ->toArray();
                    if (count($departmentIds) > 0) {
                        $query->orWhere(function($q) use ($departmentIds) {
                            $q->where('target_audience', 'department')
                              ->whereIn('target_id', $departmentIds);
                        });
                    }
                    
                    // Include course announcements for courses taught
                    $courseIds = $user->taughtCourses()->pluck('courses.id')->toArray();
                    if (count($courseIds) > 0) {
                        $query->orWhere(function($q) use ($courseIds) {
                            $q->where('target_audience', 'course')
                              ->whereIn('target_id', $courseIds);
                        });
                    }
                }
                
                if ($roles->contains('staff')) {
                    $query->orWhere('target_audience', 'staff');
                }
            })
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->where('publish_at', '<=', now());
            
        // Filter by importance if provided
        if ($request->has('importance')) {
            $query->where('importance', $request->importance);
        }
        
        $announcements = $query->orderBy('importance', 'desc')
            ->orderBy('publish_at', 'desc')
            ->paginate(15);
            
        return response()->json([
            'success' => true,
            'data' => $announcements
        ]);
    }
}
