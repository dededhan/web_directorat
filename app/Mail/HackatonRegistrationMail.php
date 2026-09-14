<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HackatonRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $registrantName,
        public string $registrantRole,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran UNJ Hackaton Berhasil Diterima',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hackaton-registration',
            with: [
                'registrantName' => $this->registrantName,
                'registrantRole' => $this->registrantRole,
            ],
        );
    }
}
