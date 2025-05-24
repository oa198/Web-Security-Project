<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ApplicationStatusUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The application instance.
     *
     * @var \App\Models\Application
     */
    public $application;

    /**
     * Create a new message instance.
     * 
     * @param \App\Models\Application $application
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the message envelope.
     * 
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        $status = ucfirst($this->application->status);
        
        return new Envelope(
            from: new Address('admissions@university.edu', 'University Admissions'),
            subject: "Application {$status} - University Student Information System",
        );
    }

    /**
     * Get the message content definition.
     * 
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.application-status-updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    
    /**
     * Build the email with custom view data.
     *
     * @return $this
     */
    public function build()
    {
        $viewData = [
            'application' => $this->application,
            'user' => $this->application->user,
            'status' => $this->application->status,
            'reviewedAt' => $this->application->reviewed_at,
            'notes' => $this->application->notes,
            'rejectionReason' => $this->application->rejection_reason,
        ];
        
        if ($this->application->status === 'approved') {
            // Include the student record in the view data if the application was approved
            $student = $this->application->user->student;
            $viewData['student'] = $student;
            $viewData['studentId'] = $student ? $student->student_id : null;
        }
        
        return $this->view('emails.application-status-updated', $viewData);
    }
}
