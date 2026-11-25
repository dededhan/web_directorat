<?php

namespace App\Mail;

use App\Models\InternationalLectureGreeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InternationalLectureGreetingMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public InternationalLectureGreeting $greeting) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->greeting->subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.international-lecture-greeting',
            with: [
                'greeting' => $this->greeting,
                'recipientName' => $this->greeting->recipient_name,
            ],
        );
    }
}
