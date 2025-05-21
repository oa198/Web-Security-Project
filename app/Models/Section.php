<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'section_number',
        'instructor_id',
        'capacity',
        'enrolled',
        'is_full',
        'waitlist_capacity',
        'waitlist_count',
        'room',
        'days',
        'start_time',
        'end_time',
        'registration_open',
        'registration_close',
        'semester',
        'academic_year',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'capacity' => 'integer',
        'enrolled' => 'integer',
        'is_full' => 'boolean',
        'waitlist_capacity' => 'integer',
        'waitlist_count' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'registration_open' => 'date',
        'registration_close' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the course that the section belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the instructor of the section.
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the students enrolled in the section.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'section_id', 'user_id', null, 'user_id')
                    ->withPivot(['status', 'enrollment_date'])
                    ->withTimestamps();
    }

    /**
     * Get the enrollments for the section.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the attendance records for the section.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the waitlisted students for the section.
     */
    public function waitlistedStudents()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'section_id', 'user_id', null, 'user_id')
                    ->withPivot(['status', 'enrollment_date'])
                    ->wherePivot('status', 'waitlisted')
                    ->withTimestamps();
    }

    /**
     * Check if the section is open for registration.
     *
     * @return bool
     */
    public function isOpenForRegistration()
    {
        $now = now()->startOfDay();
        $registrationOpen = $this->registration_open ? $this->registration_open->startOfDay() : null;
        $registrationClose = $this->registration_close ? $this->registration_close->startOfDay() : null;

        if (!$registrationOpen || !$registrationClose) {
            return false;
        }

        return $now->between($registrationOpen, $registrationClose) && $this->is_active;
    }

    /**
     * Check if the section has available space.
     *
     * @return bool
     */
    public function hasAvailableSpace()
    {
        return $this->enrolled < $this->capacity;
    }

    /**
     * Check if the section has waitlist space.
     *
     * @return bool
     */
    public function hasWaitlistSpace()
    {
        return $this->waitlist_count < $this->waitlist_capacity;
    }

    /**
     * Update the section's enrollment count and full status.
     *
     * @return void
     */
    public function updateEnrollmentStatus()
    {
        $this->enrolled = $this->enrollments()->where('status', 'active')->count();
        $this->waitlist_count = $this->enrollments()->where('status', 'waitlisted')->count();
        $this->is_full = $this->enrolled >= $this->capacity;
        $this->save();
    }

    /**
     * Scope a query to only include active sections.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include sections for a specific semester.
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
