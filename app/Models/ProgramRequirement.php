<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramRequirement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'program_id',
        'course_id',
        'required_credits',
        'min_grade',
        'requirement_type',
        'semester_recommended',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'required_credits' => 'integer',
        'semester_recommended' => 'integer',
    ];

    /**
     * Get the program that owns the requirement.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the course that the requirement belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Check if a given grade meets the minimum requirement.
     *
     * @param string $grade
     * @return bool
     */
    public function gradeRequirementMet(string $grade): bool
    {
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

        return ($gradeValues[$grade] ?? 0) >= ($gradeValues[$this->min_grade] ?? 0);
    }
}
