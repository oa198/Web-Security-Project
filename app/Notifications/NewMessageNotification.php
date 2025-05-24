<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
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
            ->where('notification_type', 'new_message')
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
        $url = url('/messages/' . $this->message->id);
        
        $mailMessage = (new MailMessage)
            ->subject('New Message: ' . ($this->message->subject ?: 'No Subject'))
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have received a new message from ' . $this->message->sender->name . '.')
            ->action('View Message', $url)
            ->line('Thank you for using our Student Information System!');
            
        // If message content is not too long, include a preview
        if (strlen($this->message->content) < 300) {
            $mailMessage->line('Message Preview:')
                        ->line('"' . $this->message->content . '"');
        }
        
        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'subject' => $this->message->subject,
            'excerpt' => \Str::limit(strip_tags($this->message->content), 100),
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->name,
            'sender_avatar' => $this->message->sender->avatar,
            'has_attachments' => $this->message->attachments->count() > 0,
            'sent_at' => $this->message->created_at,
            'url' => '/messages/' . $this->message->id,
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
            'message_id' => $this->message->id,
            'subject' => $this->message->subject ?: 'No Subject',
            'sender_name' => $this->message->sender->name,
            'sender_avatar' => $this->message->sender->avatar,
            'time' => now()->toDateTimeString(),
        ]);
    }
}
