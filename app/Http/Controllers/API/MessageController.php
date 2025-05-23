<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewMessageNotification;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $type = $request->input('type', 'inbox');
        $query = Message::with(['sender', 'recipient', 'attachments']);
        
        switch ($type) {
            case 'inbox':
                $query->inbox($userId);
                break;
            case 'sent':
                $query->sent($userId);
                break;
            case 'archived':
                $query->archived($userId);
                break;
            case 'starred':
                $query->where(function($q) use ($userId) {
                    $q->where('recipient_id', $userId)
                      ->orWhere('sender_id', $userId);
                })->starred();
                break;
            default:
                $query->inbox($userId);
        }
        
        // Filter by unread if requested
        if ($request->boolean('unread', false)) {
            $query->unread();
        }
        
        // Search in subject or content
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        $messages = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Store a newly created message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:messages,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // 10MB max per file
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Make sure sender can't send to themselves
        if (Auth::id() == $request->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot send a message to yourself'
            ], 422);
        }
        
        // Create the message
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->recipient_id = $request->recipient_id;
        $message->subject = $request->subject;
        $message->content = $request->content;
        $message->parent_id = $request->parent_id;
        $message->ip_address = $request->ip();
        $message->save();
        
        // Handle attachments if any
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message_attachments/' . $message->id, 'public');
                
                $attachment = new MessageAttachment();
                $attachment->message_id = $message->id;
                $attachment->file_name = $file->getClientOriginalName();
                $attachment->file_path = $path;
                $attachment->file_type = $file->getMimeType();
                $attachment->file_size = $file->getSize();
                $attachment->is_image = str_starts_with($file->getMimeType(), 'image/');
                $attachment->save();
            }
        }
        
        // Notify the recipient
        $recipient = User::find($request->recipient_id);
        Notification::send($recipient, new NewMessageNotification($message));

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => $message->load(['sender', 'recipient', 'attachments'])
        ], 201);
    }

    /**
     * Display the specified message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $message = Message::with(['sender', 'recipient', 'attachments', 'parent', 'replies'])->findOrFail($id);
        
        // Make sure the user is either the sender or recipient
        if (Auth::id() != $message->sender_id && Auth::id() != $message->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to view this message'
            ], 403);
        }
        
        // Mark as read if current user is the recipient and message is unread
        if (Auth::id() == $message->recipient_id && !$message->is_read) {
            $message->markAsRead();
        }
        
        return response()->json([
            'success' => true,
            'data' => $message
        ]);
    }

    /**
     * Mark message as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id): JsonResponse
    {
        $message = Message::findOrFail($id);
        
        // Ensure user is the recipient
        if (Auth::id() != $message->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to modify this message'
            ], 403);
        }
        
        $message->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Message marked as read',
            'data' => $message
        ]);
    }

    /**
     * Mark message as unread.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsUnread($id): JsonResponse
    {
        $message = Message::findOrFail($id);
        
        // Ensure user is the recipient
        if (Auth::id() != $message->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to modify this message'
            ], 403);
        }
        
        $message->markAsUnread();
        
        return response()->json([
            'success' => true,
            'message' => 'Message marked as unread',
            'data' => $message
        ]);
    }

    /**
     * Toggle starred status of a message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStar($id): JsonResponse
    {
        $message = Message::findOrFail($id);
        
        // Ensure user is either sender or recipient
        if (Auth::id() != $message->sender_id && Auth::id() != $message->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to modify this message'
            ], 403);
        }
        
        $message->toggleStar();
        
        return response()->json([
            'success' => true,
            'message' => $message->is_starred ? 'Message starred' : 'Message unstarred',
            'data' => $message
        ]);
    }

    /**
     * Archive a message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive($id): JsonResponse
    {
        $message = Message::findOrFail($id);
        
        // Ensure user is either sender or recipient
        if (Auth::id() != $message->sender_id && Auth::id() != $message->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to modify this message'
            ], 403);
        }
        
        // Archive based on user role
        if (Auth::id() == $message->sender_id) {
            $message->sender_archived = true;
        } else {
            $message->recipient_archived = true;
        }
        
        $message->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Message archived',
            'data' => $message
        ]);
    }

    /**
     * Unarchive a message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unarchive($id): JsonResponse
    {
        $message = Message::findOrFail($id);
        
        // Ensure user is either sender or recipient
        if (Auth::id() != $message->sender_id && Auth::id() != $message->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to modify this message'
            ], 403);
        }
        
        // Unarchive based on user role
        if (Auth::id() == $message->sender_id) {
            $message->sender_archived = false;
        } else {
            $message->recipient_archived = false;
        }
        
        $message->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Message unarchived',
            'data' => $message
        ]);
    }

    /**
     * Delete a message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $message = Message::findOrFail($id);
        
        // Ensure user is either sender or recipient
        if (Auth::id() != $message->sender_id && Auth::id() != $message->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to modify this message'
            ], 403);
        }
        
        // Soft delete based on user role
        if (Auth::id() == $message->sender_id) {
            $message->sender_deleted = true;
        } else {
            $message->recipient_deleted = true;
        }
        
        $message->save();
        
        // If both sender and recipient have deleted, hard delete the message
        if ($message->sender_deleted && $message->recipient_deleted) {
            // Delete attachments first
            foreach ($message->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }
            
            $message->forceDelete();
            
            return response()->json([
                'success' => true,
                'message' => 'Message permanently deleted'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Message deleted',
            'data' => $message
        ]);
    }

    /**
     * Get unread messages count.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unreadCount(): JsonResponse
    {
        $count = Message::where('recipient_id', Auth::id())
            ->where('is_read', false)
            ->where('recipient_deleted', false)
            ->count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'count' => $count
            ]
        ]);
    }

    /**
     * Download message attachment.
     *
     * @param  int  $messageId
     * @param  int  $attachmentId
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadAttachment($messageId, $attachmentId)
    {
        $message = Message::findOrFail($messageId);
        
        // Ensure user is either sender or recipient
        if (Auth::id() != $message->sender_id && Auth::id() != $message->recipient_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to access this attachment'
            ], 403);
        }
        
        $attachment = MessageAttachment::where('id', $attachmentId)
            ->where('message_id', $messageId)
            ->firstOrFail();
        
        return Storage::disk('public')->download(
            $attachment->file_path,
            $attachment->file_name
        );
    }
}
