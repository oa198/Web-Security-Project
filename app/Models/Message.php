<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'subject',
        'content',
        'is_read',
        'read_at',
        'is_starred',
        'sender_archived',
        'recipient_archived',
        'sender_deleted',
        'recipient_deleted',
        'parent_id',
        'ip_address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_starred' => 'boolean',
        'sender_archived' => 'boolean',
        'recipient_archived' => 'boolean',
        'sender_deleted' => 'boolean',
        'recipient_deleted' => 'boolean',
    ];

    /**
     * Get the sender of the message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the recipient of the message.
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Get the parent message if this is a reply.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    /**
     * Get the replies to this message.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    /**
     * Get the attachments for this message.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(MessageAttachment::class);
    }

    /**
     * Scope a query to only include unread messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include starred messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }

    /**
     * Scope a query to only include messages in the inbox.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInbox($query, $userId)
    {
        return $query->where('recipient_id', $userId)
                     ->where('recipient_deleted', false);
    }

    /**
     * Scope a query to only include sent messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSent($query, $userId)
    {
        return $query->where('sender_id', $userId)
                     ->where('sender_deleted', false);
    }

    /**
     * Scope a query to only include archived messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where(function($innerQ) use ($userId) {
                $innerQ->where('recipient_id', $userId)
                       ->where('recipient_archived', true)
                       ->where('recipient_deleted', false);
            })->orWhere(function($innerQ) use ($userId) {
                $innerQ->where('sender_id', $userId)
                       ->where('sender_archived', true)
                       ->where('sender_deleted', false);
            });
        });
    }

    /**
     * Mark the message as read.
     *
     * @return bool
     */
    public function markAsRead(): bool
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            return $this->save();
        }
        
        return true;
    }

    /**
     * Mark the message as unread.
     *
     * @return bool
     */
    public function markAsUnread(): bool
    {
        if ($this->is_read) {
            $this->is_read = false;
            $this->read_at = null;
            return $this->save();
        }
        
        return true;
    }

    /**
     * Toggle the starred status of the message.
     *
     * @return bool
     */
    public function toggleStar(): bool
    {
        $this->is_starred = !$this->is_starred;
        return $this->save();
    }
}
