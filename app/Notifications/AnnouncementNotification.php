<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AnnouncementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $announcement;

    /**
     * Create a new notification instance.
     */
    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
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
            ->where('notification_type', 'system_announcement')
            ->first();

        if ($this->announcement->send_email && 
            (!$preference || $preference->email_enabled)) {
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
        $url = url('/announcements/' . $this->announcement->id);
        
        return (new MailMessage)
            ->subject($this->getSubject())
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new announcement has been published:')
            ->line($this->announcement->title)
            ->line($this->getImportanceText())
            ->action('View Announcement', $url)
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
            'id' => $this->announcement->id,
            'title' => $this->announcement->title,
            'excerpt' => \Str::limit(strip_tags($this->announcement->content), 100),
            'importance' => $this->announcement->importance,
            'author_id' => $this->announcement->author_id,
            'author_name' => $this->announcement->author->name,
            'publish_at' => $this->announcement->publish_at,
            'url' => '/announcements/' . $this->announcement->id,
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
            'id' => $this->announcement->id,
            'title' => $this->announcement->title,
            'importance' => $this->announcement->importance,
            'time' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Get the subject line for the notification.
     *
     * @return string
     */
    protected function getSubject(): string
    {
        $importance = $this->getImportanceText();
        
        return "[{$importance}] {$this->announcement->title}";
    }
    
    /**
     * Get the importance text for the notification.
     *
     * @return string
     */
    protected function getImportanceText(): string
    {
        switch ($this->announcement->importance) {
            case 'urgent':
                return 'URGENT';
            case 'high':
                return 'Important';
            case 'medium':
                return 'Notice';
            case 'low':
            default:
                return 'Information';
        }
    }
}
