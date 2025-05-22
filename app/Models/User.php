<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'two_factor_enabled',
        'theme',
        'font_size',
        'language',
        'timezone',
        'date_format',
        'high_contrast',
        'reduced_motion',
        'screen_reader',
        'email_verified_at',
        'verification_code',
        'verification_code_expires_at',
        'google_id',
        'google_token',
        'google_refresh_token',
        'github_id',
        'github_token',
        'github_refresh_token',
        'linkedin_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_enabled' => 'boolean',
        'high_contrast' => 'boolean',
        'reduced_motion' => 'boolean',
        'screen_reader' => 'boolean',
    ];
    
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        // Generate a new verification code
        $code = $this->generateVerificationCode();
        
        // Send the notification with the code
        $this->notify(new \App\Notifications\VerificationCodeNotification($code));
    }

    /**
     * Get the courses where the user is a professor.
     */
    public function taughtCourses()
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->wherePivot('role_type', 'professor')
            ->withTimestamps();
    }

    /**
     * Get the courses where the user is a student.
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->wherePivot('role_type', 'student')
            ->withTimestamps();
    }

    /**
     * Get the courses where the user is a teaching assistant.
     */
    public function assistedCourses()
    {
        return $this->belongsToMany(Course::class, 'course_user')
            ->wherePivot('role_type', 'teaching_assistant')
            ->withTimestamps();
    }

    /**
     * Get the user's active sessions.
     */
    public function sessions()
    {
        return $this->hasMany(\App\Models\Session::class);
    }

    /**
     * Get the student record associated with the user.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
