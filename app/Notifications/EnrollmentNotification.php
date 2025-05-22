<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Enrollment;

class EnrollmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Enrollment')
            ->line('A new enrollment has been made.')
            ->line('Course: ' . $this->enrollment->course->name)
            ->line('Student: ' . $this->enrollment->user->name)
            ->action('View Enrollment', url('/enrollments/' . $this->enrollment->id))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'enrollment_id' => $this->enrollment->id,
            'course_name' => $this->enrollment->course->name,
            'student_name' => $this->enrollment->user->name,
        ];
    }
} 