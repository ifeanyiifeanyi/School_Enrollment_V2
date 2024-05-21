<?php

namespace App\Mail;

use App\Models\Application;
use App\Models\ExamManager;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $application;    
    public $examDetails;



    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Application $application)
    {
        $this->user = $user;
        $this->application = $application;
        $this->examDetails = ExamManager::where('department_id', $application->department_id)->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Confirmation Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new Content(
            html: 'emails.registration-confirmation',
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
}
