<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InovChalengeRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $registrantName;
    public string $registrantRole;

    public function __construct(string $registrantName, string $registrantRole)
    {
        $this->registrantName = $registrantName;
        $this->registrantRole = $registrantRole;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran UNJ Innovation Challenge Berhasil Diterima',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inovchalenge-registration',
            with: [
                'registrantName' => $this->registrantName,
                'registrantRole' => $this->registrantRole,
            ],
        );
    }
}
