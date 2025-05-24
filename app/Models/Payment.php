<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'financial_record_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'status',
        'receipt_number',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the financial record associated with this payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financialRecord()
    {
        return $this->belongsTo(FinancialRecord::class);
    }

    /**
     * Get the student associated with this payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function student()
    {
        return $this->hasOneThrough(
            Student::class,
            FinancialRecord::class,
            'id', // Foreign key on financial_records table
            'id', // Foreign key on students table
            'financial_record_id', // Local key on payments table
            'student_id' // Local key on financial_records table
        );
    }
}
