<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'section_id',
        'enrollment_date',
        'status',
        'grade',
        'semester',
        'academic_year',
        'waitlist_position',
        'is_auditing',
        'drop_deadline',
        'dropped_at',
        'drop_reason',
        'tuition_amount',
        'financial_hold',
        'is_paid',
        'registration_method',
        'approved_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'course_id' => 'integer',
        'section_id' => 'integer',
        'enrollment_date' => 'date',
        'status' => 'string',
        'waitlist_position' => 'integer',
        'is_auditing' => 'boolean',
        'drop_deadline' => 'date',
        'dropped_at' => 'datetime',
        'tuition_amount' => 'decimal:2',
        'financial_hold' => 'boolean',
        'is_paid' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'enrollment_date',
        'drop_deadline',
        'dropped_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the enrollment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the student that owns the enrollment.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id', 'user_id');
    }

    /**
     * Get the course that the user is enrolled in.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the section that the user is enrolled in.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the grade associated with this enrollment.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get the financial record associated with this enrollment.
     */
    public function financialRecords()
    {
        return $this->morphMany(FinancialRecord::class, 'recordable');
    }

    /**
     * Get the latest attendance record.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'user_id')
            ->where('section_id', $this->section_id);
    }

    /**
     * Check if the enrollment is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the enrollment is waitlisted.
     *
     * @return bool
     */
    public function isWaitlisted()
    {
        return $this->status === 'waitlisted';
    }

    /**
     * Check if the enrollment is completed.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the enrollment is dropped.
     *
     * @return bool
     */
    public function isDropped()
    {
        return $this->status === 'dropped';
    }

    /**
     * Mark the enrollment as active.
     *
     * @return bool
     */
    public function markActive()
    {
        $this->status = 'active';
        return $this->save();
    }

    /**
     * Mark the enrollment as waitlisted and set the waitlist position.
     *
     * @param int $position
     * @return bool
     */
    public function markWaitlisted($position)
    {
        $this->status = 'waitlisted';
        $this->waitlist_position = $position;
        return $this->save();
    }

    /**
     * Mark the enrollment as completed.
     *
     * @return bool
     */
    public function markCompleted()
    {
        $this->status = 'completed';
        return $this->save();
    }

    /**
     * Drop the enrollment.
     *
     * @param string|null $reason
     * @return bool
     */
    public function drop($reason = null)
    {
        $this->status = 'dropped';
        $this->dropped_at = now();
        
        if ($reason) {
            $this->drop_reason = $reason;
        }
        
        return $this->save();
    }

    /**
     * Get the grade for this enrollment.
     *
     * @return string|null
     */
    public function getGrade()
    {
        $grade = $this->grades()->latest()->first();
        return $grade ? $grade->grade : null;
    }

    /**
     * Get the points for this enrollment.
     *
     * @return float|null
     */
    public function getPoints()
    {
        $grade = $this->grades()->latest()->first();
        return $grade ? $grade->points : null;
    }

    /**
     * Calculate tuition amount for this enrollment.
     *
     * @return float
     */
    public function calculateTuition()
    {
        // Get course credits
        $credits = $this->course->credits;
        
        // Get base rate per credit hour (could be different based on student's program)
        $ratePerCredit = 1000.00; // Default rate per credit hour
        
        if ($this->student && $this->student->program) {
            // In a real implementation, we would get the rate per credit based on the student's program
            switch ($this->student->program) {
                case 'Computer Science':
                    $ratePerCredit = 1200.00;
                    break;
                case 'Business':
                    $ratePerCredit = 1100.00;
                    break;
                case 'Engineering':
                    $ratePerCredit = 1300.00;
                    break;
                // Add other programs
            }
        }
        
        // Calculate tuition
        $tuition = $credits * $ratePerCredit;
        
        // Update the tuition amount
        $this->tuition_amount = $tuition;
        $this->save();
        
        return $tuition;
    }

    /**
     * Scope a query to only include active enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include waitlisted enrollments.
     */
    public function scopeWaitlisted($query)
    {
        return $query->where('status', 'waitlisted');
    }

    /**
     * Scope a query to only include completed enrollments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include dropped enrollments.
     */
    public function scopeDropped($query)
    {
        return $query->where('status', 'dropped');
    }

    /**
     * Scope a query to only include enrollments for a specific semester.
     */
    public function scopeSemester($query, $semester, $academicYear)
    {
        return $query->where('semester', $semester)
                     ->where('academic_year', $academicYear);
    }

    /**
     * Scope a query to only include enrollments with financial holds.
     */
    public function scopeWithFinancialHold($query)
    {
        return $query->where('financial_hold', true);
    }

    /**
     * Scope a query to only include enrollments that are paid.
     */
    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    /**
     * Scope a query to only include enrollments that are unpaid.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('is_paid', false);
    }
} 