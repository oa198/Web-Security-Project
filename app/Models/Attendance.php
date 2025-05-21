<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'section_id',
        'date',
        'status',
        'notes',
        'check_in_time',
        'excused_absence',
        'excused_reason',
        'recorded_by',
        'semester',
        'academic_year',
        'is_at_risk'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'excused_absence' => 'boolean',
        'is_at_risk' => 'boolean',
    ];

    /**
     * Get the student associated with the attendance record.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the section associated with the attendance record.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the course through the section.
     */
    public function course()
    {
        return $this->hasOneThrough(Course::class, Section::class, 'id', 'id', 'section_id', 'course_id');
    }

    /**
     * Get the user who recorded this attendance.
     */
    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Check if the attendance record is for an absence.
     *
     * @return bool
     */
    public function isAbsent()
    {
        return $this->status === 'absent';
    }

    /**
     * Check if the attendance record is for a present student.
     *
     * @return bool
     */
    public function isPresent()
    {
        return $this->status === 'present';
    }

    /**
     * Check if the attendance record is for an excused absence.
     *
     * @return bool
     */
    public function isExcused()
    {
        return $this->excused_absence;
    }

    /**
     * Mark the attendance as present.
     *
     * @param string|null $notes
     * @return bool
     */
    public function markPresent($notes = null)
    {
        $this->status = 'present';
        $this->check_in_time = now();
        
        if ($notes) {
            $this->notes = $notes;
        }
        
        return $this->save();
    }

    /**
     * Mark the attendance as absent.
     *
     * @param string|null $notes
     * @return bool
     */
    public function markAbsent($notes = null)
    {
        $this->status = 'absent';
        $this->check_in_time = null;
        
        if ($notes) {
            $this->notes = $notes;
        }
        
        return $this->save();
    }

    /**
     * Mark the attendance as excused.
     *
     * @param string $reason
     * @param string|null $notes
     * @return bool
     */
    public function markExcused($reason, $notes = null)
    {
        $this->status = 'excused';
        $this->excused_absence = true;
        $this->excused_reason = $reason;
        
        if ($notes) {
            $this->notes = $notes;
        }
        
        return $this->save();
    }

    /**
     * Mark student as at risk based on attendance.
     *
     * @param string|null $notes
     * @return bool
     */
    public function markAtRisk($notes = null)
    {
        $this->is_at_risk = true;
        
        if ($notes) {
            $this->notes = $this->notes ? $this->notes . ' | ' . $notes : $notes;
        }
        
        return $this->save();
    }

    /**
     * Scope a query to only include attendance records for a specific status.
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
     * Scope a query to only include attendance records for a specific date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Carbon\Carbon  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope a query to only include attendance records for at-risk students.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAtRisk($query)
    {
        return $query->where('is_at_risk', true);
    }

    /**
     * Scope a query to only include attendance records for a specific semester.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $semester
     * @param  string  $academicYear
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSemester($query, $semester, $academicYear)
    {
        return $query->where('semester', $semester)
                     ->where('academic_year', $academicYear);
    }
}
