<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_id',
        'title',
        'content',
        'target_audience',
        'target_id',
        'importance',
        'publish_at',
        'expires_at',
        'is_published',
        'show_on_dashboard',
        'send_email',
        'send_notification',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publish_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_published' => 'boolean',
        'show_on_dashboard' => 'boolean',
        'send_email' => 'boolean',
        'send_notification' => 'boolean',
    ];

    /**
     * Get the author of the announcement.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope a query to only include published announcements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('publish_at', '<=', now())
                     ->where(function($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>=', now());
                     });
    }

    /**
     * Scope a query to only include announcements for a specific audience.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $audience
     * @param  int|null  $targetId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForAudience($query, $audience, $targetId = null)
    {
        return $query->where(function($q) use ($audience, $targetId) {
            // Include announcements for all users
            $q->where('target_audience', 'all');
            
            // Include announcements for the specific audience
            if ($audience) {
                $q->orWhere('target_audience', $audience);
            }
            
            // Include targeted announcements if targetId is provided
            if ($targetId) {
                $q->orWhere(function($innerQ) use ($audience, $targetId) {
                    $innerQ->where('target_audience', $audience)
                          ->where('target_id', $targetId);
                });
            }
        });
    }

    /**
     * Check if the announcement is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        $now = now();
        
        if (!$this->is_published) {
            return false;
        }
        
        if ($now->lt($this->publish_at)) {
            return false;
        }
        
        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }
        
        return true;
    }

    /**
     * Get the target entity based on target_audience and target_id.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getTarget()
    {
        if (!$this->target_id) {
            return null;
        }
        
        switch ($this->target_audience) {
            case 'department':
                return Department::find($this->target_id);
            case 'course':
                return Course::find($this->target_id);
            case 'section':
                return Section::find($this->target_id);
            default:
                return null;
        }
    }

    /**
     * Get all users who should receive this announcement.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTargetUsers()
    {
        $query = User::query();
        
        switch ($this->target_audience) {
            case 'all':
                // All users
                break;
                
            case 'students':
                $query->whereHas('student');
                break;
                
            case 'faculty':
                $query->role('faculty');
                break;
                
            case 'staff':
                $query->role('staff');
                break;
                
            case 'department':
                $query->whereHas('student.department', function($q) {
                    $q->where('id', $this->target_id);
                })->orWhereHas('taughtCourses.department', function($q) {
                    $q->where('id', $this->target_id);
                });
                break;
                
            case 'course':
                $query->whereHas('enrolledCourses', function($q) {
                    $q->where('courses.id', $this->target_id);
                })->orWhereHas('taughtCourses', function($q) {
                    $q->where('courses.id', $this->target_id);
                })->orWhereHas('assistedCourses', function($q) {
                    $q->where('courses.id', $this->target_id);
                });
                break;
                
            case 'section':
                $section = Section::find($this->target_id);
                if ($section) {
                    $query->whereHas('enrolledCourses', function($q) use ($section) {
                        $q->where('courses.id', $section->course_id)
                          ->whereHas('sections', function($sq) use ($section) {
                              $sq->where('sections.id', $section->id);
                          });
                    })->orWhere('id', $section->instructor_id);
                }
                break;
        }
        
        return $query->get();
    }
}
