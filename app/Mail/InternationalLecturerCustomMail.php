<?php

namespace App\Mail;

use App\Models\DosenInternasional;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email dengan subjek & isi yang ditulis manual oleh admin
 * (halaman Kirim Email International Lecture).
 */
class InternationalLecturerCustomMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public DosenInternasional $lecturer,
        public string $mailSubject,
        public string $mailBody,
        public bool $includeConsentButton = false,
        public ?string $buttonText = null,
        public ?string $photoPath = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: self::renderPlaceholders($this->mailSubject, $this->lecturer, $this->consentLink(), false)
        );
    }

    public function content(): Content
    {
        $consentLink = $this->consentLink();

        // Resolve absolute path for inline photo embedding
        $resolvedPhotoPath = null;
        if ($this->photoPath) {
            $candidate = \Illuminate\Support\Facades\Storage::disk('public')->path($this->photoPath);
            if (file_exists($candidate)) {
                $resolvedPhotoPath = $candidate;
            }
        }

        return new Content(
            view: 'emails.international-lecturer-custom',
            with: [
                'lecturer'             => $this->lecturer,
                'bodyHtml'             => self::renderPlaceholders($this->mailBody, $this->lecturer, $consentLink, true),
                'consentLink'          => $consentLink,
                'includeConsentButton' => $this->includeConsentButton && $consentLink,
                'buttonText'           => $this->buttonText ?: 'Give Consent / Berikan Persetujuan',
                'inlinePhotoPath'      => $resolvedPhotoPath,
            ]
        );
    }

    private function consentLink(): ?string
    {
        return $this->lecturer->consent_token
            ? route('pemeringkatan.international-lecture.consent.show', ['token' => $this->lecturer->consent_token])
            : null;
    }

    /**
     * Ganti placeholder {{...}} dengan data dosen.
     * Jika $html = true, teks di-escape dan baris baru diubah menjadi <br>.
     */
    public static function renderPlaceholders(string $text, DosenInternasional $lecturer, ?string $consentLink, bool $html): string
    {
        $values = [
            '{{nama}}' => $lecturer->nama,
            '{{title}}' => self::extractTitle($lecturer->nama),
            '{{email}}' => $lecturer->email ?? '',
            '{{jabatan}}' => $lecturer->jabatan ?? '',
            '{{universitas_asal}}' => $lecturer->universitas_asal ?? '',
            '{{negara}}' => $lecturer->negara ?? '',
            '{{subject_1}}' => $lecturer->subject_1 ?? '',
            '{{subject_2}}' => $lecturer->subject_2 ?? '',
            '{{fakultas}}' => strtoupper((string) $lecturer->fakultas),
            '{{prodi}}' => $lecturer->prodi ?? '',
            '{{consent_link}}' => $consentLink ?? '',
        ];

        if (!$html) {
            return strtr($text, $values);
        }

        $escaped = array_map(fn ($v) => e($v), $values);
        if ($consentLink) {
            $escaped['{{consent_link}}'] = '<a href="' . e($consentLink) . '" style="color:#4f46e5">' . e($consentLink) . '</a>';
        }

        return nl2br(strtr(e($text), $escaped));
    }

    private static function extractTitle(string $name): string
    {
        if (preg_match('/^(Prof\. Dr\.|Prof\.|Dr\.|Mr\.|Mrs\.|Ms\.)/i', trim($name), $m)) {
            return $m[1];
        }
        return '';
    }
}
