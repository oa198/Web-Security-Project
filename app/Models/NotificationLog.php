<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationLog extends Model
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
        'title',
        'content',
        'action_url',
        'channel',
        'status',
        'error_message',
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that the notification is for.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include unread notifications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope a query to only include notifications of a specific type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('notification_type', $type);
    }

    /**
     * Scope a query to only include notifications from a specific channel.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $channel
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromChannel($query, $channel)
    {
        return $query->where('channel', $channel);
    }

    /**
     * Scope a query to only include notifications with a specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Mark the notification as read.
     *
     * @return bool
     */
    public function markAsRead(): bool
    {
        if (is_null($this->read_at)) {
            $this->read_at = now();
            return $this->save();
        }
        
        return true;
    }

    /**
     * Mark the notification as unread.
     *
     * @return bool
     */
    public function markAsUnread(): bool
    {
        if (!is_null($this->read_at)) {
            $this->read_at = null;
            return $this->save();
        }
        
        return true;
    }

    /**
     * Update the notification status.
     *
     * @param string $status
     * @param string|null $errorMessage
     * @return bool
     */
    public function updateStatus(string $status, ?string $errorMessage = null): bool
    {
        $this->status = $status;
        
        if ($errorMessage) {
            $this->error_message = $errorMessage;
        }
        
        return $this->save();
    }

    /**
     * Get the human-readable notification type name.
     *
     * @return string
     */
    public function getNotificationTypeName(): string
    {
        return NotificationPreference::$types[$this->notification_type] ?? $this->notification_type;
    }
}
