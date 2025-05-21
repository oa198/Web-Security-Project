<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'transaction_id',
        'type',
        'amount',
        'balance',
        'description',
        'status',
        'payment_method',
        'reference_number',
        'semester',
        'academic_year',
        'payment_plan_id',
        'receipt_number',
        'due_date',
        'payment_date',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'date',
    ];

    /**
     * Get the student that owns the financial record.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the payment plan associated with the financial record.
     */
    public function paymentPlan()
    {
        return $this->belongsTo(PaymentPlan::class);
    }

    /**
     * Get the user who created the record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the record.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include records of a specific type.
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
     * Scope a query to only include records with a specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include records for a specific semester.
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

    /**
     * Scope a query to only include records that are overdue.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                     ->whereNotNull('due_date')
                     ->where('due_date', '<', now());
    }

    /**
     * Generate a receipt for the financial record.
     *
     * @return string
     */
    public function generateReceipt()
    {
        $this->receipt_number = 'RCPT-' . $this->transaction_id;
        $this->save();
        
        return $this->receipt_number;
    }
}
