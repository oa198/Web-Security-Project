<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicCalendar extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'academic_term_id',
        'event_type',
        'name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'description',
        'location',
        'is_holiday',
        'is_campus_closed',
        'color_code',
        'visibility',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_holiday' => 'boolean',
        'is_campus_closed' => 'boolean',
    ];

    /**
     * Get the academic term associated with the calendar event.
     */
    public function academicTerm(): BelongsTo
    {
        return $this->belongsTo(AcademicTerm::class);
    }

    /**
     * Scope a query to only include events visible to a specific audience.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $visibility
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleTo($query, $visibility)
    {
        return $query->where('visibility', $visibility)
                     ->orWhere('visibility', 'public');
    }

    /**
     * Scope a query to only include events within a date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $startDate
     * @param  string  $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->where(function($q) use ($startDate, $endDate) {
            // Events that start within the range
            $q->whereBetween('start_date', [$startDate, $endDate])
              // Or events that end within the range
              ->orWhereBetween('end_date', [$startDate, $endDate])
              // Or events that span the entire range
              ->orWhere(function($query) use ($startDate, $endDate) {
                  $query->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
              });
        });
    }

    /**
     * Check if this event is currently active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        $now = now()->toDateString();
        
        if ($this->end_date) {
            return $now >= $this->start_date && $now <= $this->end_date;
        }
        
        return $now == $this->start_date;
    }
}
