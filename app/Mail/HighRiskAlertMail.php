<?php

namespace App\Mail;

use App\Models\FreedomWall;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HighRiskAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public FreedomWall $post;
    public string      $adminName;

    public function __construct(FreedomWall $post, string $adminName)
    {
        $this->post      = $post;
        $this->adminName = $adminName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 High-Risk Post Alert — Project Jeremiah 33:3',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.high-risk-alert',
        );
    }
}
