<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'request_id',
        'type',
        'description',
        'status',
        'reason',
        'metadata',
        'course_id',
        'section_id',
        'semester',
        'academic_year',
        'submission_date',
        'decision_date',
        'decision_by',
        'decision_comments',
        'advisor_status',
        'department_status',
        'registrar_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'json',
        'submission_date' => 'date',
        'decision_date' => 'date',
    ];

    /**
     * Get the student that made the request.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the course related to the request, if any.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the section related to the request, if any.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the documents attached to this request.
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Check if the request has been approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the request has been rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if the request is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === 'pending' || $this->status === 'in_progress';
    }

    /**
     * Approve the request.
     *
     * @param string $decisionBy
     * @param string|null $comments
     * @return bool
     */
    public function approve($decisionBy, $comments = null)
    {
        $this->status = 'approved';
        $this->decision_date = now();
        $this->decision_by = $decisionBy;
        
        if ($comments) {
            $this->decision_comments = $comments;
        }
        
        return $this->save();
    }

    /**
     * Reject the request.
     *
     * @param string $decisionBy
     * @param string|null $comments
     * @return bool
     */
    public function reject($decisionBy, $comments = null)
    {
        $this->status = 'rejected';
        $this->decision_date = now();
        $this->decision_by = $decisionBy;
        
        if ($comments) {
            $this->decision_comments = $comments;
        }
        
        return $this->save();
    }

    /**
     * Update the advisor status of the request.
     *
     * @param string $status
     * @return bool
     */
    public function updateAdvisorStatus($status)
    {
        $this->advisor_status = $status;
        return $this->save();
    }

    /**
     * Update the department status of the request.
     *
     * @param string $status
     * @return bool
     */
    public function updateDepartmentStatus($status)
    {
        $this->department_status = $status;
        return $this->save();
    }

    /**
     * Update the registrar status of the request.
     *
     * @param string $status
     * @return bool
     */
    public function updateRegistrarStatus($status)
    {
        $this->registrar_status = $status;
        return $this->save();
    }

    /**
     * Scope a query to only include pending requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'in_progress']);
    }

    /**
     * Scope a query to only include approved requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope a query to only include requests of a specific type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include requests for a specific semester.
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
