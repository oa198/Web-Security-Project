<?php

namespace App\Notifications;

use App\Models\Exam;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class GradePostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $exam;

    /**
     * Create a new notification instance.
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // Check user preferences
        $preference = $notifiable->notificationPreferences()
            ->where('notification_type', 'grade_posted')
            ->first();

        if (!$preference || $preference->email_enabled) {
            $channels[] = 'mail';
        }

        // Add broadcast channel for real-time notifications
        $channels[] = 'broadcast';
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/student/exams/' . $this->exam->id . '/results');
        
        return (new MailMessage)
            ->subject('Grade Posted: ' . $this->exam->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your grade for "' . $this->exam->title . '" in ' . $this->exam->course->name . ' has been posted.')
            ->action('View Your Grade', $url)
            ->line('Thank you for using our Student Information System!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'exam_id' => $this->exam->id,
            'title' => $this->exam->title,
            'course_id' => $this->exam->course_id,
            'course_name' => $this->exam->course->name,
            'course_code' => $this->exam->course->code,
            'graded_at' => now(),
            'url' => '/student/exams/' . $this->exam->id . '/results',
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'exam_id' => $this->exam->id,
            'title' => $this->exam->title,
            'course_name' => $this->exam->course->name,
            'time' => now()->toDateTimeString(),
        ]);
    }
}
