<?php

namespace App\Services;

use App\Models\FinancialRecord;
use App\Models\PaymentPlan;
use App\Models\Scholarship;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Exception;

class FinancialService
{
    /**
     * Get a student's financial records.
     *
     * @param int $studentId
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getStudentFinancialRecords(int $studentId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = FinancialRecord::where('student_id', $studentId);
        
        // Apply filters
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['semester']) && isset($filters['academic_year'])) {
            $query->where('semester', $filters['semester'])
                  ->where('academic_year', $filters['academic_year']);
        }
        
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }
        
        // Order by creation date descending
        $query->orderBy('created_at', 'desc');
        
        return $query->paginate($perPage);
    }
    
    /**
     * Calculate tuition for a student for a semester.
     *
     * @param int $studentId
     * @param string $semester
     * @param string $academicYear
     * @return float
     */
    public function calculateSemesterTuition(int $studentId, string $semester, string $academicYear): float
    {
        $student = Student::findOrFail($studentId);
        
        $enrollments = Enrollment::where('user_id', $student->user_id)
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->where('status', 'active')
            ->with('course')
            ->get();
            
        $totalTuition = 0;
        
        foreach ($enrollments as $enrollment) {
            $totalTuition += $enrollment->calculateTuition();
        }
        
        return $totalTuition;
    }
    
    /**
     * Process a payment for a student.
     *
     * @param int $studentId
     * @param float $amount
     * @param string $paymentMethod
     * @param string $referenceNumber
     * @param string $semester
     * @param string $academicYear
     * @param string $description
     * @param int $createdBy
     * @return FinancialRecord
     */
    public function processPayment(
        int $studentId,
        float $amount,
        string $paymentMethod,
        string $referenceNumber,
        string $semester,
        string $academicYear,
        string $description,
        int $createdBy
    ): FinancialRecord {
        $student = Student::findOrFail($studentId);
        
        // Get the current balance
        $currentBalance = $student->getCurrentBalance();
        
        // Calculate the new balance
        $newBalance = $currentBalance - $amount;
        
        // Create the financial record
        $record = $student->financialRecords()->create([
            'transaction_id' => 'PYMT' . time() . $studentId,
            'type' => 'payment',
            'amount' => $amount,
            'balance' => $newBalance,
            'description' => $description,
            'status' => 'paid',
            'payment_method' => $paymentMethod,
            'reference_number' => $referenceNumber,
            'semester' => $semester,
            'academic_year' => $academicYear,
            'payment_date' => now(),
            'created_by' => $createdBy,
        ]);
        
        // Generate a receipt
        $record->generateReceipt();
        
        // If the student had a financial hold and the new balance is <= 0, remove the hold
        if ($student->financial_hold && $newBalance <= 0) {
            $student->financial_hold = false;
            $student->save();
        }
        
        // Update payment status for relevant enrollments
        $this->updateEnrollmentPaymentStatus($student, $semester, $academicYear);
        
        return $record;
    }
    
    /**
     * Update payment status for enrollments based on current balance.
     *
     * @param Student $student
     * @param string $semester
     * @param string $academicYear
     * @return void
     */
    private function updateEnrollmentPaymentStatus(Student $student, string $semester, string $academicYear): void
    {
        $balance = $student->getCurrentBalance();
        
        // If the balance is <= 0, mark all enrollments as paid
        if ($balance <= 0) {
            $student->enrollments()
                ->where('semester', $semester)
                ->where('academic_year', $academicYear)
                ->where('status', 'active')
                ->update(['is_paid' => true]);
        }
    }
    
    /**
     * Create a new payment plan for a student.
     *
     * @param int $studentId
     * @param array $planData
     * @param int $createdBy
     * @return PaymentPlan
     */
    public function createPaymentPlan(int $studentId, array $planData, int $createdBy): PaymentPlan
    {
        $student = Student::findOrFail($studentId);
        
        // Calculate installment amount if not provided
        if (!isset($planData['installment_amount'])) {
            $planData['installment_amount'] = $planData['total_amount'] / $planData['number_of_installments'];
        }
        
        // Merge the created_by field
        $planData['created_by'] = $createdBy;
        
        // Create the payment plan
        $plan = $student->paymentPlans()->create($planData);
        
        return $plan;
    }
    
    /**
     * Process a payment plan installment.
     *
     * @param int $paymentPlanId
     * @param float $amount
     * @param string $paymentMethod
     * @param string $referenceNumber
     * @param int $createdBy
     * @return FinancialRecord
     */
    public function processInstallmentPayment(
        int $paymentPlanId,
        float $amount,
        string $paymentMethod,
        string $referenceNumber,
        int $createdBy
    ): FinancialRecord {
        $paymentPlan = PaymentPlan::with('student')->findOrFail($paymentPlanId);
        $student = $paymentPlan->student;
        
        // Get the current balance
        $currentBalance = $student->getCurrentBalance();
        
        // Calculate the new balance
        $newBalance = $currentBalance - $amount;
        
        // Create the financial record
        $record = $student->financialRecords()->create([
            'transaction_id' => 'INST' . time() . $paymentPlanId,
            'type' => 'payment',
            'amount' => $amount,
            'balance' => $newBalance,
            'description' => "Payment plan installment for {$paymentPlan->name}",
            'status' => 'paid',
            'payment_method' => $paymentMethod,
            'reference_number' => $referenceNumber,
            'payment_plan_id' => $paymentPlan->id,
            'semester' => $paymentPlan->semester,
            'academic_year' => $paymentPlan->academic_year,
            'payment_date' => now(),
            'created_by' => $createdBy,
        ]);
        
        // Generate a receipt
        $record->generateReceipt();
        
        // Check if payment plan is completed
        $remainingBalance = $paymentPlan->getRemainingBalance();
        if ($remainingBalance <= 0) {
            $paymentPlan->status = 'completed';
            $paymentPlan->save();
        }
        
        // If the student had a financial hold and the new balance is <= 0, remove the hold
        if ($student->financial_hold && $newBalance <= 0) {
            $student->financial_hold = false;
            $student->save();
        }
        
        // Update payment status for relevant enrollments
        $this->updateEnrollmentPaymentStatus($student, $paymentPlan->semester, $paymentPlan->academic_year);
        
        return $record;
    }
    
    /**
     * Apply a scholarship to a student.
     *
     * @param int $studentId
     * @param int $scholarshipId
     * @param string $semester
     * @param string $academicYear
     * @param int $createdBy
     * @return FinancialRecord
     * @throws Exception
     */
    public function applyScholarship(
        int $studentId,
        int $scholarshipId,
        string $semester,
        string $academicYear,
        int $createdBy
    ): FinancialRecord {
        $student = Student::findOrFail($studentId);
        $scholarship = Scholarship::findOrFail($scholarshipId);
        
        // Check if the scholarship is active
        if ($scholarship->status !== 'active') {
            throw new Exception('Scholarship is not active.');
        }
        
        // Check if the student is eligible
        if (!$scholarship->isStudentEligible($student)) {
            throw new Exception('Student is not eligible for this scholarship.');
        }
        
        // Calculate the scholarship amount
        $amount = $scholarship->calculateAmount($student);
        
        // Get the current balance
        $currentBalance = $student->getCurrentBalance();
        
        // Calculate the new balance
        $newBalance = $currentBalance - $amount;
        
        // Create the financial record
        $record = $student->financialRecords()->create([
            'transaction_id' => 'SCHLR' . time() . $scholarshipId,
            'type' => 'scholarship',
            'amount' => $amount,
            'balance' => $newBalance,
            'description' => "Applied scholarship: {$scholarship->name}",
            'status' => 'processed',
            'semester' => $semester,
            'academic_year' => $academicYear,
            'created_by' => $createdBy,
        ]);
        
        // If the student had a financial hold and the new balance is <= 0, remove the hold
        if ($student->financial_hold && $newBalance <= 0) {
            $student->financial_hold = false;
            $student->save();
        }
        
        // Update payment status for relevant enrollments
        $this->updateEnrollmentPaymentStatus($student, $semester, $academicYear);
        
        // Add the student to the scholarship recipients
        $scholarship->recipients()->attach($student->id);
        
        return $record;
    }
    
    /**
     * Generate a financial statement for a student.
     *
     * @param int $studentId
     * @param string $semester
     * @param string $academicYear
     * @return array
     */
    public function generateFinancialStatement(int $studentId, string $semester, string $academicYear): array
    {
        $student = Student::with(['user'])->findOrFail($studentId);
        
        // Get all financial records for the semester
        $records = $student->financialRecords()
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->orderBy('created_at')
            ->get();
        
        // Get current enrollments for the semester
        $enrollments = $student->enrollments()
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->where('status', 'active')
            ->with(['course', 'section'])
            ->get();
        
        // Get payment plans for the semester
        $paymentPlans = $student->paymentPlans()
            ->where('semester', $semester)
            ->where('academic_year', $academicYear)
            ->get();
        
        // Calculate total charges
        $totalTuition = 0;
        $totalFees = 0;
        $totalScholarships = 0;
        $totalPayments = 0;
        $totalRefunds = 0;
        
        foreach ($records as $record) {
            switch ($record->type) {
                case 'tuition':
                    $totalTuition += $record->amount;
                    break;
                case 'fee':
                    $totalFees += $record->amount;
                    break;
                case 'scholarship':
                    $totalScholarships += $record->amount;
                    break;
                case 'payment':
                    $totalPayments += $record->amount;
                    break;
                case 'refund':
                    $totalRefunds += $record->amount;
                    break;
            }
        }
        
        $totalCharges = $totalTuition + $totalFees;
        $totalCredits = $totalScholarships + $totalPayments + $totalRefunds;
        $currentBalance = $totalCharges - $totalCredits;
        
        return [
            'student' => [
                'id' => $student->id,
                'user_id' => $student->user_id,
                'name' => $student->user->name,
                'student_id' => $student->student_id,
                'program' => $student->program,
                'department' => $student->department->name,
            ],
            'semester' => $semester,
            'academic_year' => $academicYear,
            'statement_date' => now()->format('Y-m-d'),
            'enrollments' => $enrollments->map(function ($enrollment) {
                return [
                    'course_code' => $enrollment->course->code,
                    'course_title' => $enrollment->course->title,
                    'section' => $enrollment->section->section_number,
                    'credits' => $enrollment->course->credits,
                    'tuition' => $enrollment->tuition_amount,
                    'is_paid' => $enrollment->is_paid,
                ];
            }),
            'payment_plans' => $paymentPlans->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'total_amount' => $plan->total_amount,
                    'paid_amount' => $plan->getPaidAmount(),
                    'remaining_balance' => $plan->getRemainingBalance(),
                    'status' => $plan->status,
                ];
            }),
            'charges' => [
                'tuition' => $totalTuition,
                'fees' => $totalFees,
                'total_charges' => $totalCharges,
            ],
            'credits' => [
                'scholarships' => $totalScholarships,
                'payments' => $totalPayments,
                'refunds' => $totalRefunds,
                'total_credits' => $totalCredits,
            ],
            'balance' => $currentBalance,
            'records' => $records->map(function ($record) {
                return [
                    'date' => $record->created_at->format('Y-m-d'),
                    'transaction_id' => $record->transaction_id,
                    'type' => $record->type,
                    'description' => $record->description,
                    'amount' => $record->amount,
                    'balance' => $record->balance,
                    'status' => $record->status,
                ];
            }),
        ];
    }
    
    /**
     * Place or remove a financial hold on a student.
     *
     * @param int $studentId
     * @param bool $holdStatus
     * @param string|null $reason
     * @param int $updatedBy
     * @return Student
     */
    public function updateFinancialHold(int $studentId, bool $holdStatus, ?string $reason = null, int $updatedBy): Student
    {
        $student = Student::findOrFail($studentId);
        
        $student->financial_hold = $holdStatus;
        $student->save();
        
        // Log the action
        $action = $holdStatus ? 'placed' : 'removed';
        $description = "Financial hold {$action} on student";
        
        if ($reason) {
            $description .= ": {$reason}";
        }
        
        // Create a record just for tracking purposes
        $student->financialRecords()->create([
            'transaction_id' => 'HOLD' . time() . $studentId,
            'type' => 'admin',
            'amount' => 0,
            'balance' => $student->getCurrentBalance(),
            'description' => $description,
            'status' => 'processed',
            'semester' => 'N/A',
            'academic_year' => 'N/A',
            'created_by' => $updatedBy,
        ]);
        
        return $student;
    }
    
    /**
     * Get available scholarships that a student may be eligible for.
     *
     * @param int $studentId
     * @return Collection
     */
    public function getAvailableScholarships(int $studentId): Collection
    {
        $student = Student::findOrFail($studentId);
        
        // Get all active scholarships
        $scholarships = Scholarship::active()->acceptingApplications()->get();
        
        // Filter out scholarships the student is already receiving
        $studentScholarshipIds = $student->financialRecords()
            ->where('type', 'scholarship')
            ->pluck('metadata->scholarship_id')
            ->filter()
            ->toArray();
        
        return $scholarships->filter(function ($scholarship) use ($student, $studentScholarshipIds) {
            // Check if already received
            if (in_array($scholarship->id, $studentScholarshipIds)) {
                return false;
            }
            
            // Check eligibility
            return $scholarship->isStudentEligible($student);
        });
    }
}
