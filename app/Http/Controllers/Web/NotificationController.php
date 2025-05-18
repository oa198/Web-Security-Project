<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // In a real app, we would fetch notifications from the database
        // For now, we'll use dummy data
        $notifications = [
            [
                'id' => 1,
                'title' => 'Database Final Project Posted',
                'content' => 'The final project for Database Systems has been posted. Due May 30.',
                'type' => 'info',
                'read' => false,
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 2,
                'title' => 'Quiz Grade Posted',
                'content' => 'Your Web Development Quiz 3 has been graded. Score: 92%.',
                'type' => 'success',
                'read' => false,
                'created_at' => now()->subDay()
            ],
            [
                'id' => 3,
                'title' => 'Class Canceled',
                'content' => 'Computer Networks class on Friday, May 19 has been canceled.',
                'type' => 'warning',
                'read' => false,
                'created_at' => now()->subDays(2)
            ],
            [
                'id' => 4,
                'title' => 'New Course Resources Available',
                'content' => 'New learning resources have been posted for Software Engineering.',
                'type' => 'info',
                'read' => true,
                'created_at' => now()->subDays(4)
            ],
            [
                'id' => 5,
                'title' => 'Tuition Payment Received',
                'content' => 'Your spring semester tuition payment has been successfully processed.',
                'type' => 'success',
                'read' => true,
                'created_at' => now()->subWeek()
            ]
        ];

        // Calculate notification stats
        $totalNotifications = count($notifications);
        $unreadNotifications = count(array_filter($notifications, function($notification) {
            return !$notification['read'];
        }));
        $readNotifications = $totalNotifications - $unreadNotifications;

        return view('notifications', compact('notifications', 'totalNotifications', 'unreadNotifications', 'readNotifications'));
    }

    /**
     * Mark a notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        // In a real app, we would mark the notification as read in the database
        // For now, we'll just return a success response
        
        return redirect()->back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        // In a real app, we would mark all notifications as read in the database
        // For now, we'll just return a success response
        
        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    /**
     * Display notification details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // In a real app, we would fetch the notification from the database
        // For now, we'll use dummy data
        
        return redirect()->back()->with('info', 'Notification details would be shown here');
    }

    /**
     * Update notification settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        // In a real app, we would save the settings to the database
        // For now, we'll just return a success response
        
        return redirect()->back()->with('success', 'Notification settings updated successfully');
    }
} 