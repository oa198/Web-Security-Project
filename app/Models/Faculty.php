<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
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
        'dean',
        'location'
    ];

    /**
     * Get the departments that belong to this faculty.
     */
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get all students in this faculty through departments.
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, Department::class);
    }

    /**
     * Get all courses in this faculty through departments.
     */
    public function courses()
    {
        return $this->hasManyThrough(Course::class, Department::class);
    }
}
