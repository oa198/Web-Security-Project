<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'amount',
        'description',
        'due_date',
        'status',
        'invoice_number',
        'payment_type',
        'academic_term_id',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the student associated with this invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the financial records associated with this invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class);
    }

    /**
     * Get the payments associated with this invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            FinancialRecord::class,
            'invoice_id', // Foreign key on financial_records table
            'financial_record_id', // Foreign key on payments table
            'id', // Local key on invoices table
            'id' // Local key on financial_records table
        );
    }

    /**
     * Get the academic term associated with this invoice.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function academicTerm()
    {
        return $this->belongsTo(AcademicTerm::class);
    }
}
