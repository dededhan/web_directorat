<?php

namespace App\Mail;

use App\Models\Responden;
use App\Models\EmailTemplate;
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
        $normalizedCategory = $this->normalizeCategory($this->responden->category);
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
        if (empty($this->responden->email)) {
            throw new \RuntimeException('Responden email is required');
        }

        if (empty($this->responden->token)) {
            throw new \RuntimeException('Token is required');
        }

        $normalizedCategory = $this->normalizeCategory($this->responden->category);
        $displayTitle = $this->normalizeTitle($this->responden->title);
        $surveyLink = $this->generateSurveyLink($normalizedCategory);

        // Get templates from database
        $templateEn = EmailTemplate::getTemplate($normalizedCategory, 'en');
        $templateId = EmailTemplate::getTemplate($normalizedCategory, 'id');

        return new Content(
            view: 'emails.responden-invitation-dynamic',
            with: [
                'responden' => $this->responden,
                'surveyLink' => $surveyLink,
                'normalizedCategory' => $normalizedCategory,
                'displayTitle' => $displayTitle,
                'templateEn' => $templateEn,
                'templateId' => $templateId,
            ]
        );
    }

    protected function generateSurveyLink(string $normalizedCategory): string
    {
        $routeName = $normalizedCategory === 'academic'
            ? 'qs-academic.index'
            : 'qs-employee.index';

        return route($routeName, ['token' => $this->responden->token]);
    }

    private function normalizeCategory(?string $category): string
    {
        $value = strtolower(trim((string) $category));
        if ($value === '') {
            return 'employee';
        }
        $academic = ['academic', 'researcher', 'reseracher'];
        $employer = ['employer', 'employeer', 'industri', 'employee'];
        foreach ($academic as $k) {
            if (str_contains($value, $k)) return 'academic';
        }
        foreach ($employer as $k) {
            if (str_contains($value, $k)) return 'employee';
        }
        return 'employee';
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
