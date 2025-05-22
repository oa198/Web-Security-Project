<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'student_id',
        'department_id',
        'program',
        'credits_completed',
        'gpa',
        'academic_standing',
        'advisor',
        'level',
        'admission_date',
        'expected_graduation_date',
        'financial_hold',
        'academic_hold'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'credits_completed' => 'integer',
        'gpa' => 'decimal:2',
        'admission_date' => 'date',
        'expected_graduation_date' => 'date',
        'financial_hold' => 'boolean',
        'academic_hold' => 'boolean',
    ];

    /**
     * Get the user associated with the student.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department the student belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the faculty the student belongs to through department.
     */
    public function faculty()
    {
        return $this->hasOneThrough(Faculty::class, Department::class, 'id', 'id', 'department_id', 'faculty_id');
    }

    /**
     * Get the enrollments for the student.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'user_id', 'user_id');
    }

    /**
     * Get the courses the student is enrolled in.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id', 'user_id');
    }

    /**
     * Get the sections the student is enrolled in.
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'enrollments', 'user_id', 'section_id', 'user_id');
    }

    /**
     * Get the student's grades.
     */
    public function grades()
    {
        return $this->hasManyThrough(Grade::class, Enrollment::class, 'user_id', 'enrollment_id', 'user_id');
    }

    /**
     * Get the student's financial records.
     */
    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class);
    }

    /**
     * Get the student's payment plans.
     */
    public function paymentPlans()
    {
        return $this->hasMany(PaymentPlan::class);
    }

    /**
     * Get the student's attendance records.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the student's requests.
     */
    public function requests()
    {
        return $this->hasMany(StudentRequest::class);
    }

    /**
     * Get the student's documents.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get today's class schedule for the student.
     */
    public function todaySchedule()
    {
        return $this->hasManyThrough(Schedule::class, Enrollment::class, 'user_id', 'course_id', 'user_id', 'course_id')
            ->whereDate('date', now()->toDateString())
            ->orderBy('start_time');
    }

    /**
     * Get the student's pending assignments.
     */
    public function pendingAssignments()
    {
        return $this->hasManyThrough(Assignment::class, Enrollment::class, 'user_id', 'course_id', 'user_id', 'course_id')
            ->where('due_date', '>', now())
            ->whereDoesntHave('submissions', function ($query) {
                $query->where('student_id', $this->id);
            });
    }

    /**
     * Calculate the student's GPA based on completed courses.
     * 
     * @return float
     */
    public function calculateGPA()
    {
        $grades = $this->grades;
        
        if ($grades->isEmpty()) {
            return 0.0;
        }
        
        $totalPoints = 0;
        $totalCredits = 0;
        
        foreach ($grades as $grade) {
            $enrollment = $grade->enrollment;
            $course = $enrollment->course;
            $totalPoints += $grade->points * $course->credits;
            $totalCredits += $course->credits;
        }
        
        return $totalCredits > 0 ? $totalPoints / $totalCredits : 0.0;
    }

    /**
     * Check if the student has any hold on their account.
     * 
     * @return bool
     */
    public function hasHold()
    {
        return $this->financial_hold || $this->academic_hold;
    }

    /**
     * Check if the student can register for courses.
     * 
     * @return bool
     */
    public function canRegister()
    {
        return !$this->hasHold();
    }

    /**
     * Get the student's current balance.
     * 
     * @return float
     */
    public function getCurrentBalance()
    {
        $latestRecord = $this->financialRecords()->latest()->first();
        return $latestRecord ? $latestRecord->balance : 0.0;
    }
}
