<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'title',
        'description',
        'credits',
        'semester',
        'year',
        'professor_id',
        'department_id',
        'prerequisite_ids',
        'is_active',
        'level',
        'max_capacity',
        'current_enrollment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'credits' => 'integer',
        'year' => 'integer',
        'professor_id' => 'integer',
        'department_id' => 'integer',
        'prerequisite_ids' => 'array',
        'is_active' => 'boolean',
        'max_capacity' => 'integer',
        'current_enrollment' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the department that the course belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the professor for the course.
     */
    public function professor()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->wherePivot('role_type', 'professor')
            ->withTimestamps();
    }

    /**
     * Get the students enrolled in the course.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->wherePivot('role_type', 'student')
            ->withTimestamps();
    }

    /**
     * Get the grades for the course.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get the teaching assistants for the course.
     */
    public function teachingAssistants()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->wherePivot('role_type', 'teaching_assistant')
            ->withTimestamps();
    }

    /**
     * Get the sections for this course.
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Get the enrollments for this course.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the prerequisite courses for this course.
     */
    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisites', 'course_id', 'prerequisite_id');
    }

    /**
     * Get the courses that have this course as a prerequisite.
     */
    public function followupCourses()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisites', 'prerequisite_id', 'course_id');
    }

    /**
     * Get the student requests related to this course.
     */
    public function studentRequests()
    {
        return $this->hasMany(StudentRequest::class);
    }

    /**
     * Check if a student has the prerequisites for this course.
     *
     * @param Student $student
     * @return bool
     */
    public function hasPrerequisites(Student $student)
    {
        if (!$this->prerequisite_ids || empty($this->prerequisite_ids)) {
            return true;
        }

        $completedCourseIds = $student->grades()
            ->whereHas('enrollment', function ($query) {
                $query->where('status', 'completed');
            })
            ->with('enrollment.course')
            ->get()
            ->pluck('enrollment.course_id')
            ->toArray();

        $missingPrerequisites = array_diff($this->prerequisite_ids, $completedCourseIds);
        
        return empty($missingPrerequisites);
    }

    /**
     * Check if the course has available seats in any section.
     *
     * @return bool
     */
    public function hasAvailableSeats()
    {
        return $this->sections()->where('is_full', false)->count() > 0;
    }

    /**
     * Calculate the pass rate for this course.
     *
     * @return float
     */
    public function getPassRate()
    {
        $totalGrades = $this->grades()->count();
        
        if ($totalGrades === 0) {
            return 0;
        }
        
        $passingGrades = $this->grades()->passing()->count();
        
        return ($passingGrades / $totalGrades) * 100;
    }

    /**
     * Scope a query to only include active courses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include courses from a specific department.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $departmentId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Scope a query to only include courses with available seats.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAvailableSeats($query)
    {
        return $query->whereHas('sections', function ($query) {
            $query->where('is_full', false);
        });
    }

    /**
     * Scope a query to only include courses of a specific level.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $level
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfLevel($query, $level)
    {
        return $query->where('level', $level);
    }
} 