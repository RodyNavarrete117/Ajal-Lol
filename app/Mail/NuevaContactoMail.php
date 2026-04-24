<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevaContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public object $formulario;

    public function __construct(object $formulario)
    {
        $this->formulario = $formulario;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva solicitud de: ' . $this->formulario->nombre_completo
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.nueva-contacto');
    }
}