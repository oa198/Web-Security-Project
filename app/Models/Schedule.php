<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'date',
        'start_time',
        'end_time',
        'room',
        'type',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the course that owns the schedule.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the students enrolled in this schedule.
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, Enrollment::class, 'course_id', 'user_id', 'course_id', 'user_id');
    }
}
