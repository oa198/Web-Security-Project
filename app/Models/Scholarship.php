<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scholarship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'amount',
        'amount_type',
        'minimum_gpa',
        'minimum_credits',
        'duration_semesters',
        'renewable',
        'renewal_criteria',
        'eligibility_criteria',
        'application_deadline',
        'start_date',
        'end_date',
        'status',
        'max_recipients',
        'created_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'minimum_gpa' => 'decimal:2',
        'minimum_credits' => 'integer',
        'duration_semesters' => 'integer',
        'renewable' => 'boolean',
        'application_deadline' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'max_recipients' => 'integer',
    ];

    /**
     * Get the students who have received this scholarship.
     */
    public function recipients()
    {
        return $this->belongsToMany(Student::class, 'student_scholarship');
    }

    /**
     * Get the financial records related to this scholarship.
     */
    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class);
    }

    /**
     * Get the user who created the scholarship.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Calculate the scholarship amount for a student based on type.
     *
     * @param Student $student
     * @return float
     */
    public function calculateAmount(Student $student)
    {
        if ($this->amount_type === 'fixed') {
            return $this->amount;
        }
        
        // If percentage-based, calculate based on tuition
        // This is a simplified example. In reality, would need to get the actual tuition cost
        $tuitionAmount = 10000.00; // Example tuition amount
        return ($this->amount / 100) * $tuitionAmount;
    }

    /**
     * Check if a student is eligible for this scholarship.
     *
     * @param Student $student
     * @return bool
     */
    public function isStudentEligible(Student $student)
    {
        // Check if the scholarship is active
        if ($this->status !== 'active') {
            return false;
        }
        
        // Check if application deadline has passed
        if ($this->application_deadline && now()->gt($this->application_deadline)) {
            return false;
        }
        
        // Check GPA requirement
        if ($this->minimum_gpa && $student->gpa < $this->minimum_gpa) {
            return false;
        }
        
        // Check credits requirement
        if ($this->minimum_credits && $student->credits_completed < $this->minimum_credits) {
            return false;
        }
        
        // Additional eligibility criteria would need to be implemented based on the actual criteria stored
        
        return true;
    }

    /**
     * Scope a query to only include active scholarships.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include scholarships that are currently accepting applications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcceptingApplications($query)
    {
        return $query->where('status', 'active')
                     ->where(function($q) {
                         $q->whereNull('application_deadline')
                           ->orWhere('application_deadline', '>=', now());
                     });
    }
}
