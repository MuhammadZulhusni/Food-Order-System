<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Websitemail extends Mailable
{
    use Queueable, SerializesModels;

    // Email subject and body (passed to the view)
    public $subject, $body;

    /**
     * Create a new message instance.
     *
     * @param string $subject Email subject
     * @param string $body    Email body content
     */
    public function __construct($subject, $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Define the email envelope (header).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject, // Set the email subject
        );
    }

    /**
     * Define the content and view for the email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email', // Use resources/views/email.blade.php
        );
    }

    /**
     * Attachments for the email (none here).
     */
    public function attachments(): array
    {
        return [];
    }
}
