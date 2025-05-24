<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prerequisite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'prerequisite_course_id',
        'min_grade',
        'notes',
        'can_be_concurrent',
        'can_be_waived',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'can_be_concurrent' => 'boolean',
        'can_be_waived' => 'boolean',
    ];

    /**
     * Get the course that requires this prerequisite.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the prerequisite course.
     */
    public function prerequisiteCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'prerequisite_course_id');
    }

    /**
     * Check if a student meets this prerequisite.
     *
     * @param Student $student
     * @return bool
     */
    public function isSatisfiedBy(Student $student): bool
    {
        // If the prerequisite can be waived and has been waived for this student
        if ($this->can_be_waived && $this->checkWaiver($student)) {
            return true;
        }

        // Get the student's grade in the prerequisite course
        $enrollment = Enrollment::where('user_id', $student->user_id)
            ->where('course_id', $this->prerequisite_course_id)
            ->first();

        // If no enrollment, check if student is currently enrolled if concurrent is allowed
        if (!$enrollment && $this->can_be_concurrent) {
            $currentEnrollment = Enrollment::where('user_id', $student->user_id)
                ->where('course_id', $this->prerequisite_course_id)
                ->whereHas('section', function ($query) {
                    $query->whereHas('course', function ($q) {
                        $q->where('academic_term_id', AcademicTerm::where('is_active', true)->first()->id);
                    });
                })
                ->exists();
            
            return $currentEnrollment;
        } elseif (!$enrollment) {
            return false;
        }

        // Check if the grade meets the minimum requirement
        $grade = Grade::where('enrollment_id', $enrollment->id)->first();
        
        if (!$grade) {
            return false;
        }

        $gradeValues = [
            'A+' => 4.0,
            'A' => 4.0,
            'A-' => 3.7,
            'B+' => 3.3,
            'B' => 3.0,
            'B-' => 2.7,
            'C+' => 2.3,
            'C' => 2.0,
            'C-' => 1.7,
            'D+' => 1.3,
            'D' => 1.0,
            'D-' => 0.7,
            'F' => 0.0,
        ];

        return ($gradeValues[$grade->letter_grade] ?? 0) >= ($gradeValues[$this->min_grade] ?? 0);
    }

    /**
     * Check if a prerequisite waiver exists for this student.
     *
     * @param Student $student
     * @return bool
     */
    private function checkWaiver(Student $student): bool
    {
        // This is a placeholder - you'd implement waiver checking logic here
        // based on your specific waiver tracking mechanism
        return false;
    }
}
