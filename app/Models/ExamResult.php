<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exam_id',
        'student_id',
        'score',
        'grade',
        'status',
        'feedback',
        'section_scores',
        'is_absent',
        'is_excused',
        'absence_reason',
        'submitted_at',
        'graded_at',
        'graded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'score' => 'decimal:2',
        'section_scores' => 'json',
        'is_absent' => 'boolean',
        'is_excused' => 'boolean',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    /**
     * Get the exam associated with the result.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Get the student associated with the result.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the user who graded the exam.
     */
    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    /**
     * Check if the student passed the exam.
     *
     * @return bool
     */
    public function isPassed(): bool
    {
        if ($this->is_absent && !$this->is_excused) {
            return false;
        }
        
        return $this->score >= $this->exam->passing_marks;
    }

    /**
     * Get the percentage score.
     *
     * @return float
     */
    public function getPercentageScore(): float
    {
        if ($this->exam->total_marks == 0) {
            return 0;
        }
        
        return ($this->score / $this->exam->total_marks) * 100;
    }

    /**
     * Generate a letter grade based on percentage score.
     *
     * @return string
     */
    public function generateGrade(): string
    {
        $percentage = $this->getPercentageScore();
        
        if ($percentage >= 90) {
            return 'A+';
        } elseif ($percentage >= 85) {
            return 'A';
        } elseif ($percentage >= 80) {
            return 'A-';
        } elseif ($percentage >= 75) {
            return 'B+';
        } elseif ($percentage >= 70) {
            return 'B';
        } elseif ($percentage >= 65) {
            return 'B-';
        } elseif ($percentage >= 60) {
            return 'C+';
        } elseif ($percentage >= 55) {
            return 'C';
        } elseif ($percentage >= 50) {
            return 'C-';
        } elseif ($percentage >= 45) {
            return 'D+';
        } elseif ($percentage >= 40) {
            return 'D';
        } else {
            return 'F';
        }
    }
}
