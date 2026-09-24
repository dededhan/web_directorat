<?php

namespace App\Mail;

use App\Models\QsSessionRespondent;
use App\Models\RespondenBank;
use App\Models\QsSession;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SessionConsentMail extends Mailable
{
    use Queueable, SerializesModels;

    public RespondenBank $bankRespondent;
    public QsSessionRespondent $sessionRespondent;
    public QsSession $session;

    public function __construct(
        RespondenBank $bankRespondent,
        QsSessionRespondent $sessionRespondent,
        QsSession $session
    ) {
        $this->bankRespondent = $bankRespondent;
        $this->sessionRespondent = $sessionRespondent;
        $this->session = $session;
    }

    public function envelope(): Envelope
    {
        $normalizedCategory = $this->sessionRespondent->category ?? 'employee';
        $template = EmailTemplate::getTemplate($normalizedCategory, 'en');

        if ($template) {
            $subject = $template->subject;
        } else {
            $categoryName = ucfirst($normalizedCategory);
            $subject = "Consent Letter for {$categoryName} Respondent Universitas Negeri Jakarta QS World University Ranking";
        }

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        $normalizedCategory = $this->sessionRespondent->category ?? 'employee';
        $displayTitle = $this->normalizeTitle($this->bankRespondent->title);
        $consentLink = route('consent.show', ['token' => $this->sessionRespondent->token]);

        // Get templates from database
        $templateEn = EmailTemplate::getTemplate($normalizedCategory, 'en');
        $templateId = EmailTemplate::getTemplate($normalizedCategory, 'id');

        return new Content(
            view: 'emails.session-consent-invitation',
            with: [
                'bankRespondent' => $this->bankRespondent,
                'sessionRespondent' => $this->sessionRespondent,
                'session' => $this->session,
                'consentLink' => $consentLink,
                'normalizedCategory' => $normalizedCategory,
                'displayTitle' => $displayTitle,
                'templateEn' => $templateEn,
                'templateId' => $templateId,
            ]
        );
    }

    private function normalizeTitle(?string $title): string
    {
        $value = strtolower(trim((string) $title));
        $value = rtrim($value, '.');
        $map = [
            'mr' => 'Mr.',
            'mrs' => 'Mrs.',
            'ms' => 'Ms.',
        ];
        return $map[$value] ?? ucwords($value);
    }
}
