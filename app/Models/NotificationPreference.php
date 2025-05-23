<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'notification_type',
        'email_enabled',
        'sms_enabled',
        'in_app_enabled',
        'push_enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_enabled' => 'boolean',
        'sms_enabled' => 'boolean',
        'in_app_enabled' => 'boolean',
        'push_enabled' => 'boolean',
    ];

    /**
     * The available notification types.
     * 
     * @var array
     */
    public static $types = [
        'system_announcement' => 'System Announcements',
        'course_announcement' => 'Course Announcements',
        'grade_posted' => 'Grade Posted',
        'assignment_due' => 'Assignment Due Soon',
        'exam_reminder' => 'Exam Reminder',
        'new_message' => 'New Message',
        'registration_open' => 'Registration Open',
        'payment_due' => 'Payment Due',
        'account_hold' => 'Account Hold',
        'schedule_change' => 'Schedule Change',
        'course_enrollment' => 'Course Enrollment',
        'document_approved' => 'Document Approved',
        'security_alert' => 'Security Alert',
    ];

    /**
     * Get the user that owns the notification preference.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if any notification channel is enabled.
     *
     * @return bool
     */
    public function isAnyChannelEnabled(): bool
    {
        return $this->email_enabled || 
               $this->sms_enabled || 
               $this->in_app_enabled || 
               $this->push_enabled;
    }

    /**
     * Get all enabled channels.
     *
     * @return array
     */
    public function getEnabledChannels(): array
    {
        $channels = [];
        
        if ($this->email_enabled) {
            $channels[] = 'email';
        }
        
        if ($this->sms_enabled) {
            $channels[] = 'sms';
        }
        
        if ($this->in_app_enabled) {
            $channels[] = 'in_app';
        }
        
        if ($this->push_enabled) {
            $channels[] = 'push';
        }
        
        return $channels;
    }

    /**
     * Get the human-readable notification type name.
     *
     * @return string
     */
    public function getNotificationTypeName(): string
    {
        return self::$types[$this->notification_type] ?? $this->notification_type;
    }
}
