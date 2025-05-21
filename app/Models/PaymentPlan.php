<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'name',
        'total_amount',
        'number_of_installments',
        'installment_amount',
        'start_date',
        'end_date',
        'status',
        'payment_frequency',
        'notes',
        'semester',
        'academic_year',
        'created_by',
        'approved_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'number_of_installments' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the student that owns the payment plan.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the financial records associated with the payment plan.
     */
    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class);
    }

    /**
     * Get the user who created the payment plan.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved the payment plan.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Calculate the paid amount for this payment plan.
     *
     * @return float
     */
    public function getPaidAmount()
    {
        return $this->financialRecords()->where('status', 'paid')->sum('amount');
    }

    /**
     * Calculate the remaining balance for this payment plan.
     *
     * @return float
     */
    public function getRemainingBalance()
    {
        return $this->total_amount - $this->getPaidAmount();
    }

    /**
     * Calculate the payment progress as a percentage.
     *
     * @return float
     */
    public function getPaymentProgress()
    {
        if ($this->total_amount == 0) {
            return 100.0;
        }
        
        return ($this->getPaidAmount() / $this->total_amount) * 100;
    }

    /**
     * Check if the payment plan is completed.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->getRemainingBalance() <= 0 || $this->status === 'completed';
    }

    /**
     * Generate the due dates for all installments.
     *
     * @return array
     */
    public function generateInstallmentDueDates()
    {
        $dueDates = [];
        $startDate = $this->start_date->copy();
        
        for ($i = 0; $i < $this->number_of_installments; $i++) {
            $dueDates[] = $startDate->copy();
            
            // Advance to next due date based on payment frequency
            switch ($this->payment_frequency) {
                case 'monthly':
                    $startDate->addMonth();
                    break;
                case 'bi-monthly':
                    $startDate->addMonths(2);
                    break;
                case 'quarterly':
                    $startDate->addMonths(3);
                    break;
                default:
                    $startDate->addMonth();
            }
        }
        
        return $dueDates;
    }

    /**
     * Scope a query to only include active payment plans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include completed payment plans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include payment plans for a specific semester.
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
