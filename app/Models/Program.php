<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'department_id',
        'credits_required',
        'degree_type',
        'duration_years',
        'description',
        'is_active',
        'coordinator_name',
        'coordinator_email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'credits_required' => 'integer',
        'duration_years' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the department that owns the program.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the students enrolled in this program.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the requirements for this program.
     */
    public function requirements(): HasMany
    {
        return $this->hasMany(ProgramRequirement::class);
    }

    /**
     * Get the courses required for this program.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'program_requirements')
                    ->withPivot(['required_credits', 'min_grade', 'requirement_type', 'semester_recommended'])
                    ->withTimestamps();
    }

    /**
     * Get the core courses for this program.
     */
    public function coreCourses(): BelongsToMany
    {
        return $this->courses()->wherePivot('requirement_type', 'core');
    }

    /**
     * Get the elective courses for this program.
     */
    public function electiveCourses(): BelongsToMany
    {
        return $this->courses()->wherePivot('requirement_type', 'elective');
    }

    /**
     * Get the general education courses for this program.
     */
    public function generalEducationCourses(): BelongsToMany
    {
        return $this->courses()->wherePivot('requirement_type', 'general_education');
    }

    /**
     * Calculate the total number of courses required to complete this program.
     *
     * @return int
     */
    public function getTotalRequiredCoursesAttribute(): int
    {
        return $this->requirements()->count();
    }

    /**
     * Get the faculty members associated with this program.
     */
    public function faculty()
    {
        return $this->department->faculty();
    }
}
