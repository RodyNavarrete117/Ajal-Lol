<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $resetUrl;
    public string $userName;

    public function __construct(string $resetUrl, string $userName = '')
    {
        $this->resetUrl = $resetUrl;
        $this->userName = $userName ?: 'Usuario';
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Restablecer contraseña — Ajal-LoL');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reset-password');
    }
}