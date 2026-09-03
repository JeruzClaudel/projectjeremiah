<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;
    public string $studentName;

    public function __construct(string $otp, string $studentName)
    {
        $this->otp         = $otp;
        $this->studentName = $studentName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Reactivation Code — Project Jeremiah 33:3',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.student-otp',
        );
    }
}
