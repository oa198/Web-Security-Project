<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'total_points',
        'due_date',
        'type',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_points' => 'decimal:2',
        'due_date' => 'datetime',
        'is_published' => 'boolean',
    ];

    /**
     * Get the course that owns the assignment.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the submissions for the assignment.
     */
    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    /**
     * Get the students who have submitted this assignment.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'assignment_submissions')
            ->withPivot(['submitted_at', 'grade', 'feedback'])
            ->withTimestamps();
    }
}
