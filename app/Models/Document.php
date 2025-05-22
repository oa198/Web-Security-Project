<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'title',
        'type',
        'file_path',
        'file_size',
        'uploaded_at',
    ];

    protected $dates = [
        'uploaded_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
