<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'section_id',
        'academic_term_id',
        'title',
        'exam_type',
        'start_datetime',
        'end_datetime',
        'duration_minutes',
        'location',
        'weight',
        'description',
        'instructions',
        'total_marks',
        'passing_marks',
        'is_published',
        'allow_retake',
        'is_proctored',
        'is_online',
        'allowed_materials',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'duration_minutes' => 'integer',
        'weight' => 'decimal:2',
        'total_marks' => 'integer',
        'passing_marks' => 'integer',
        'is_published' => 'boolean',
        'allow_retake' => 'boolean',
        'is_proctored' => 'boolean',
        'is_online' => 'boolean',
        'allowed_materials' => 'json',
    ];

    /**
     * Get the course associated with the exam.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the section associated with the exam.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the academic term associated with the exam.
     */
    public function academicTerm(): BelongsTo
    {
        return $this->belongsTo(AcademicTerm::class);
    }

    /**
     * Get the user who created the exam.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the results for this exam.
     */
    public function results(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }

    /**
     * Check if the exam is currently ongoing.
     *
     * @return bool
     */
    public function isOngoing(): bool
    {
        $now = now();
        return $now->between($this->start_datetime, $this->end_datetime);
    }

    /**
     * Check if the exam is upcoming.
     *
     * @return bool
     */
    public function isUpcoming(): bool
    {
        return now()->lt($this->start_datetime);
    }

    /**
     * Check if the exam has ended.
     *
     * @return bool
     */
    public function hasEnded(): bool
    {
        return now()->gt($this->end_datetime);
    }

    /**
     * Calculate the average score for this exam.
     *
     * @return float|null
     */
    public function getAverageScore(): ?float
    {
        $results = $this->results()->where('is_absent', false)->get();
        
        if ($results->isEmpty()) {
            return null;
        }
        
        return $results->avg('score');
    }

    /**
     * Get the passing rate for this exam.
     *
     * @return float|null
     */
    public function getPassingRate(): ?float
    {
        $results = $this->results()->where('is_absent', false)->get();
        
        if ($results->isEmpty()) {
            return null;
        }
        
        $passedCount = $results->filter(function ($result) {
            return $result->score >= $this->passing_marks;
        })->count();
        
        return ($passedCount / $results->count()) * 100;
    }

    /**
     * Get students who are eligible to take this exam.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEligibleStudents()
    {
        if ($this->section_id) {
            return $this->section->students;
        }
        
        return $this->course->students;
    }
}
