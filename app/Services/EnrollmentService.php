<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

class EnrollmentService
{
    /**
     * Register a student for a course section.
     *
     * @param int $studentId
     * @param int $sectionId
     * @param string $semester
     * @param string $academicYear
     * @return Enrollment
     * @throws Exception
     */
    public function registerForSection(int $studentId, int $sectionId, string $semester, string $academicYear): Enrollment
    {
        // Begin a database transaction
        return DB::transaction(function () use ($studentId, $sectionId, $semester, $academicYear) {
            $student = Student::findOrFail($studentId);
            $section = Section::findOrFail($sectionId);
            $course = $section->course;
            
            // Check if student has any holds
            if ($student->hasHold()) {
                throw new Exception('Registration failed: Student has a financial or academic hold.');
            }
            
            // Check if the section is open for registration
            if (!$section->isOpenForRegistration()) {
                throw new Exception('Registration failed: Registration is not open for this section.');
            }
            
            // Check if the student meets the prerequisites
            if (!$course->hasPrerequisites($student)) {
                throw new Exception('Registration failed: Student does not meet course prerequisites.');
            }
            
            // Check if the student is already enrolled in this section
            $existingEnrollment = Enrollment::where('user_id', $student->user_id)
                ->where('section_id', $sectionId)
                ->where('semester', $semester)
                ->where('academic_year', $academicYear)
                ->first();
                
            if ($existingEnrollment) {
                throw new Exception('Registration failed: Student is already enrolled in this section.');
            }
            
            // Check for schedule conflicts
            $conflicts = $this->checkScheduleConflicts($student->user_id, $section, $semester, $academicYear);
            if (!empty($conflicts)) {
                throw new Exception('Registration failed: Schedule conflict with ' . $conflicts[0]->course->code);
            }
            
            // Create the enrollment based on availability
            if ($section->hasAvailableSpace()) {
                // Regular enrollment
                $enrollment = Enrollment::create([
                    'user_id' => $student->user_id,
                    'course_id' => $course->id,
                    'section_id' => $section->id,
                    'enrollment_date' => now(),
                    'status' => 'active',
                    'semester' => $semester,
                    'academic_year' => $academicYear,
                    'drop_deadline' => $this->calculateDropDeadline($semester, $academicYear),
                    'is_paid' => false,
                    'registration_method' => 'web',
                ]);
                
                // Update section enrollment count
                $section->enrolled += 1;
                $section->is_full = ($section->enrolled >= $section->capacity);
                $section->save();
                
                // Calculate tuition
                $enrollment->calculateTuition();
                
                return $enrollment;
            } else if ($section->hasWaitlistSpace()) {
                // Waitlist enrollment
                $waitlistPosition = $section->waitlist_count + 1;
                
                $enrollment = Enrollment::create([
                    'user_id' => $student->user_id,
                    'course_id' => $course->id,
                    'section_id' => $section->id,
                    'enrollment_date' => now(),
                    'status' => 'waitlisted',
                    'waitlist_position' => $waitlistPosition,
                    'semester' => $semester,
                    'academic_year' => $academicYear,
                    'is_paid' => false,
                    'registration_method' => 'web',
                ]);
                
                // Update waitlist count
                $section->waitlist_count += 1;
                $section->save();
                
                return $enrollment;
            } else {
                throw new Exception('Registration failed: Section is full and waitlist is full.');
            }
        });
    }
    
    /**
     * Drop a course for a student.
     *
     * @param int $enrollmentId
     * @param string|null $reason
     * @return bool
     * @throws Exception
     */
    public function dropCourse(int $enrollmentId, ?string $reason = null): bool
    {
        return DB::transaction(function () use ($enrollmentId, $reason) {
            $enrollment = Enrollment::findOrFail($enrollmentId);
            $section = $enrollment->section;
            
            // Check if the drop deadline has passed
            if ($enrollment->drop_deadline && now()->gt($enrollment->drop_deadline)) {
                throw new Exception('Drop failed: Drop deadline has passed.');
            }
            
            // Process the drop based on enrollment status
            if ($enrollment->status === 'active') {
                // Active enrollment - reduce section enrollment count
                $section->enrolled -= 1;
                $section->is_full = ($section->enrolled >= $section->capacity);
                $section->save();
                
                // Move someone from waitlist to active if there is a waitlist
                $this->promoteFromWaitlist($section);
            } elseif ($enrollment->status === 'waitlisted') {
                // Waitlisted enrollment - reduce waitlist count and reorder waitlist
                $section->waitlist_count -= 1;
                $section->save();
                
                // Reorder waitlist positions
                $this->reorderWaitlist($section);
            }
            
            // Mark the enrollment as dropped
            $enrollment->drop($reason);
            
            // If the enrollment was paid, generate a refund based on drop date
            if ($enrollment->is_paid) {
                $this->generateRefund($enrollment);
            }
            
            return true;
        });
    }
    
    /**
     * Check for schedule conflicts for a user.
     *
     * @param int $userId
     * @param Section $newSection
     * @param string $semester
     * @param string $academicYear
     * @return Collection
     */
    private function checkScheduleConflicts(int $userId, Section $newSection, string $semester, string $academicYear): Collection
    {
        $userSections = Section::whereHas('enrollments', function ($query) use ($userId, $semester, $academicYear) {
            $query->where('user_id', $userId)
                  ->where('status', 'active')
                  ->where('semester', $semester)
                  ->where('academic_year', $academicYear);
        })->with('course')->get();
        
        $conflicts = collect();
        
        foreach ($userSections as $section) {
            // Check for day conflicts
            $newSectionDays = str_split($newSection->days);
            $sectionDays = str_split($section->days);
            
            $dayConflict = false;
            foreach ($newSectionDays as $day) {
                if (in_array($day, $sectionDays)) {
                    $dayConflict = true;
                    break;
                }
            }
            
            if (!$dayConflict) {
                continue;
            }
            
            // Check for time conflicts
            $newStartTime = strtotime($newSection->start_time);
            $newEndTime = strtotime($newSection->end_time);
            $sectionStartTime = strtotime($section->start_time);
            $sectionEndTime = strtotime($section->end_time);
            
            // Check if the times overlap
            if (
                ($newStartTime >= $sectionStartTime && $newStartTime < $sectionEndTime) ||
                ($newEndTime > $sectionStartTime && $newEndTime <= $sectionEndTime) ||
                ($newStartTime <= $sectionStartTime && $newEndTime >= $sectionEndTime)
            ) {
                $conflicts->push($section);
            }
        }
        
        return $conflicts;
    }
    
    /**
     * Promote the next student from the waitlist to active enrollment.
     *
     * @param Section $section
     * @return bool
     */
    private function promoteFromWaitlist(Section $section): bool
    {
        $nextWaitlisted = Enrollment::where('section_id', $section->id)
            ->where('status', 'waitlisted')
            ->orderBy('waitlist_position')
            ->first();
            
        if ($nextWaitlisted) {
            $nextWaitlisted->status = 'active';
            $nextWaitlisted->save();
            
            $section->enrolled += 1;
            $section->waitlist_count -= 1;
            $section->save();
            
            // Reorder the remaining waitlist
            $this->reorderWaitlist($section);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Reorder the waitlist positions after a drop.
     *
     * @param Section $section
     * @return void
     */
    private function reorderWaitlist(Section $section): void
    {
        $waitlisted = Enrollment::where('section_id', $section->id)
            ->where('status', 'waitlisted')
            ->orderBy('waitlist_position')
            ->get();
            
        $position = 1;
        foreach ($waitlisted as $enrollment) {
            $enrollment->waitlist_position = $position++;
            $enrollment->save();
        }
    }
    
    /**
     * Generate a refund for a dropped course.
     *
     * @param Enrollment $enrollment
     * @return void
     */
    private function generateRefund(Enrollment $enrollment): void
    {
        // Calculate refund amount based on when the course was dropped
        $enrollmentDate = $enrollment->enrollment_date;
        $droppedDate = $enrollment->dropped_at;
        $daysSinceEnrollment = $enrollmentDate->diffInDays($droppedDate);
        
        // Refund policy: 
        // - 100% refund if dropped within 7 days of enrollment
        // - 75% refund if dropped within 14 days
        // - 50% refund if dropped within 21 days
        // - 0% refund after 21 days
        $refundPercentage = 0;
        
        if ($daysSinceEnrollment <= 7) {
            $refundPercentage = 100;
        } elseif ($daysSinceEnrollment <= 14) {
            $refundPercentage = 75;
        } elseif ($daysSinceEnrollment <= 21) {
            $refundPercentage = 50;
        }
        
        if ($refundPercentage > 0) {
            $refundAmount = ($enrollment->tuition_amount * $refundPercentage) / 100;
            
            // Create a financial record for the refund
            $student = Student::where('user_id', $enrollment->user_id)->first();
            
            if ($student) {
                $student->financialRecords()->create([
                    'transaction_id' => 'REF' . time() . $enrollment->id,
                    'type' => 'refund',
                    'amount' => $refundAmount,
                    'balance' => $student->getCurrentBalance() - $refundAmount,
                    'description' => "Refund for dropped course {$enrollment->course->code}",
                    'status' => 'processed',
                    'semester' => $enrollment->semester,
                    'academic_year' => $enrollment->academic_year,
                    'created_by' => 1, // System user ID
                ]);
            }
        }
    }
    
    /**
     * Calculate the drop deadline for a semester.
     *
     * @param string $semester
     * @param string $academicYear
     * @return \Carbon\Carbon
     */
    private function calculateDropDeadline(string $semester, string $academicYear): \Carbon\Carbon
    {
        // This is a simplified implementation
        // In a real application, this would depend on the academic calendar
        $now = now();
        return $now->addDays(45); // Typically around 6-7 weeks into a semester
    }
    
    /**
     * Get all enrollments for a student.
     *
     * @param int $studentId
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getStudentEnrollments(int $studentId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $student = Student::findOrFail($studentId);
        $query = Enrollment::where('user_id', $student->user_id);
        
        // Apply filters
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['semester']) && isset($filters['academic_year'])) {
            $query->where('semester', $filters['semester'])
                  ->where('academic_year', $filters['academic_year']);
        }
        
        if (isset($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }
        
        // Order by enrollment date descending
        $query->orderBy('enrollment_date', 'desc');
        
        return $query->with(['course', 'section', 'section.instructor'])
                     ->paginate($perPage);
    }
    
    /**
     * Get a student's current schedule.
     *
     * @param int $studentId
     * @param string|null $semester
     * @param string|null $academicYear
     * @return Collection
     */
    public function getStudentSchedule(int $studentId, ?string $semester = null, ?string $academicYear = null): Collection
    {
        $student = Student::findOrFail($studentId);
        
        $query = Enrollment::where('user_id', $student->user_id)
                           ->where('status', 'active');
        
        if ($semester && $academicYear) {
            $query->where('semester', $semester)
                  ->where('academic_year', $academicYear);
        } else {
            // Default to current semester
            $currentSemester = 'Spring 2025'; // This should be determined dynamically
            $currentAcademicYear = '2024-2025'; // This should be determined dynamically
            
            $query->where('semester', $currentSemester)
                  ->where('academic_year', $currentAcademicYear);
        }
        
        return $query->with(['course', 'section', 'section.instructor'])->get();
    }
    
    /**
     * Get a list of students enrolled in a section.
     *
     * @param int $sectionId
     * @return Collection
     */
    public function getSectionEnrollments(int $sectionId): Collection
    {
        return Enrollment::where('section_id', $sectionId)
                         ->where('status', 'active')
                         ->with(['user'])
                         ->get();
    }
    
    /**
     * Get a list of students on the waitlist for a section.
     *
     * @param int $sectionId
     * @return Collection
     */
    public function getSectionWaitlist(int $sectionId): Collection
    {
        return Enrollment::where('section_id', $sectionId)
                         ->where('status', 'waitlisted')
                         ->orderBy('waitlist_position')
                         ->with(['user'])
                         ->get();
    }
}
