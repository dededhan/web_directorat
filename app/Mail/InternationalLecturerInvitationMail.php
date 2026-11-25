<?php

namespace App\Mail;

use App\Models\DosenInternasional;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InternationalLecturerInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public DosenInternasional $lecturer,
        public string $languageMode = 'bilingual',
    ) {}

    public function envelope(): Envelope
    {
        $template = EmailTemplate::getTemplate('academic', $this->languageMode === 'id' ? 'id' : 'en');
        $subject = $template?->subject ?? 'Consent Letter for Academic Respondent Universitas Negeri Jakarta QS World University Ranking';
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        $templateEn = EmailTemplate::getTemplate('academic', 'en');
        $templateId = EmailTemplate::getTemplate('academic', 'id');
        $consentLink = route('pemeringkatan.international-lecture.consent.show', ['token' => $this->lecturer->consent_token]);
        $displayTitle = $this->normalizeTitle($this->lecturer->nama);

        return new Content(
            view: 'emails.international-lecturer-invitation',
            with: [
                'lecturer' => $this->lecturer,
                'templateEn' => $templateEn,
                'templateId' => $templateId,
                'consentLink' => $consentLink,
                'displayTitle' => $displayTitle,
                'languageMode' => $this->languageMode,
            ]
        );
    }

    private function normalizeTitle(string $name): string
    {
        if (preg_match('/^(Prof\. Dr\.|Prof\.|Dr\.|Mr\.|Mrs\.|Ms\.)/i', trim($name), $m)) {
            return $m[1];
        }
        return '';
    }
}
