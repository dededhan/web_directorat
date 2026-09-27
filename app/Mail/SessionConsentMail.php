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
    public string $languageMode;

    public function __construct(
        RespondenBank $bankRespondent,
        QsSessionRespondent $sessionRespondent,
        QsSession $session,
        ?string $languageMode = null
    ) {
        $this->bankRespondent = $bankRespondent;
        $this->sessionRespondent = $sessionRespondent;
        $this->session = $session;
        $this->languageMode = in_array($languageMode, ['bilingual', 'en', 'id']) 
            ? $languageMode 
            : $session->getLanguageMode();
    }

    public function envelope(): Envelope
    {
        $normalizedCategory = $this->sessionRespondent->category ?? 'employee';
        $template = $this->languageMode === 'id'
            ? $this->resolveTemplate($normalizedCategory, 'id')
            : $this->resolveTemplate($normalizedCategory, 'en');

        if ($template) {
            $subject = is_array($template) ? ($template['subject'] ?? '') : $template->subject;
        } else {
            $categoryName = ucfirst($normalizedCategory);
            $subject = $this->languageMode === 'id'
                ? "Surat Persetujuan untuk Responden {$categoryName} Universitas Negeri Jakarta QS World University Ranking"
                : "Consent Letter for {$categoryName} Respondent Universitas Negeri Jakarta QS World University Ranking";
        }

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        $normalizedCategory = $this->sessionRespondent->category ?? 'employee';
        $displayTitle = $this->normalizeTitle($this->bankRespondent->title);
        $consentLink = route('consent.show', ['token' => $this->sessionRespondent->token]);

        $templateEn = $this->resolveTemplate($normalizedCategory, 'en');
        $templateId = $this->resolveTemplate($normalizedCategory, 'id');

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
                'languageMode' => $this->languageMode,
            ]
        );
    }

    /**
     * Resolve template from session override or database.
     */
    public function resolveTemplate(string $category, string $lang)
    {
        $custom = $this->session->getCustomTemplate($category, $lang);
        if ($custom) {
            return (object) $custom;
        }

        return EmailTemplate::getTemplate($category, $lang);
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
