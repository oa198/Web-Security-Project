<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'faculty_id',
        'head_of_department'
    ];

    /**
     * Get the faculty that the department belongs to.
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the students in this department.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the courses offered by this department.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
