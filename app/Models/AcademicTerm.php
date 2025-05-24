<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicTerm extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'start_date',
        'end_date',
        'registration_start_date',
        'registration_end_date',
        'add_drop_deadline',
        'withdrawal_deadline',
        'is_active',
        'academic_year',
        'term_type',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_start_date' => 'date',
        'registration_end_date' => 'date',
        'add_drop_deadline' => 'date',
        'withdrawal_deadline' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the calendar events for this academic term.
     */
    public function calendarEvents(): HasMany
    {
        return $this->hasMany(AcademicCalendar::class);
    }

    /**
     * Get the courses offered in this academic term.
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'term_id');
    }

    /**
     * Get the exams scheduled in this academic term.
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Check if the term is currently active.
     *
     * @return bool
     */
    public function isCurrentTerm(): bool
    {
        $now = now();
        return $now->between($this->start_date, $this->end_date) && $this->is_active;
    }

    /**
     * Check if registration is open for this term.
     *
     * @return bool
     */
    public function isRegistrationOpen(): bool
    {
        $now = now();
        return $now->between($this->registration_start_date, $this->registration_end_date) && $this->is_active;
    }

    /**
     * Check if the add/drop period is active.
     *
     * @return bool
     */
    public function isAddDropActive(): bool
    {
        $now = now();
        return $now->between($this->start_date, $this->add_drop_deadline) && $this->is_active;
    }

    /**
     * Check if the withdrawal period is active.
     *
     * @return bool
     */
    public function isWithdrawalActive(): bool
    {
        $now = now();
        return $now->between($this->add_drop_deadline, $this->withdrawal_deadline) && $this->is_active;
    }
}
