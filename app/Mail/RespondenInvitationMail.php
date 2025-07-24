<?php

namespace App\Mail;

use App\Models\Responden;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RespondenInvitationMail extends Mailable
{
    use Queueable, SerializesModels;
    public Responden $responden;

    public function __construct(Responden $responden)
    {
        $this->responden = $responden;
    }
    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Undangan Pengisian Survei QS');
    }

    public function content(): Content
    {
        // Ensure required fields exist
        if (empty($this->responden->email)) {
            throw new \RuntimeException('Responden email is required');
        }

        if (empty($this->responden->token)) {
            throw new \RuntimeException('Token is required');
        }

        return new Content(
            view: 'emails.responden-invitation',
            with: [
                'responden' => $this->responden,
                'surveyLink' => $this->generateSurveyLink()
            ]
        );
    }

protected function generateSurveyLink(): string
{
    $routeName = $this->responden->category === 'academic'
        ? 'qs-academic.index'
        : 'qs-employee.index';

    return route($routeName, ['token' => $this->responden->token]);
}
}
