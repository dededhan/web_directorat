<?php

namespace App\Jobs;

use App\Mail\InternationalLecturerCustomMail;
use App\Mail\InternationalLecturerInvitationMail;
use App\Models\DosenInternasional;
use App\Models\InternationalLecturerEmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendInternationalLecturerEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Jumlah percobaan maksimal jika terjadi error pengiriman.
     */
    public int $tries = 3;

    /**
     * Waktu timeout per percobaan (detik).
     */
    public int $timeout = 60;

    /**
     * Jeda antar percobaan ulang (detik).
     */
    public int $backoff = 10;

    /**
     * @param int         $lecturerId
     * @param string      $languageMode  bilingual | en | id (untuk template sistem)
     * @param int|null    $logId         ID InternationalLecturerEmailLog (opsional)
     * @param array|null  $customContent Isi email manual: subject, body, include_consent_button, button_text.
     *                                   Jika null, memakai template sistem QS Academic Respondent.
     */
    public function __construct(
        public int $lecturerId,
        public string $languageMode = 'bilingual',
        public ?int $logId = null,
        public ?array $customContent = null,
    ) {}

    public function handle(): void
    {
        $log = $this->logId ? InternationalLecturerEmailLog::find($this->logId) : null;
        $lecturer = DosenInternasional::find($this->lecturerId);

        if (!$lecturer || !$lecturer->email) {
            $log?->update(['status' => 'failed', 'error' => 'Data dosen atau alamat email tidak ditemukan.']);
            return;
        }

        $lecturer->update(['email_status' => 'sending', 'email_error' => null]);
        $log?->update(['status' => 'sending', 'error' => null]);

        try {
            Mail::to($lecturer->email)->send($this->buildMailable($lecturer));

            $lecturer->update([
                'email_status' => 'sent',
                'email_sent_at' => now(),
                'email_error' => null,
            ]);
            $log?->update(['status' => 'sent', 'sent_at' => now(), 'error' => null]);
        } catch (Throwable $e) {
            $lecturer->update([
                'email_status' => 'failed',
                'email_error' => $e->getMessage(),
            ]);
            $log?->update(['status' => 'failed', 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function buildMailable(DosenInternasional $lecturer)
    {
        if ($this->customContent && isset($this->customContent['subject'])) {
            // Pass photo path to mailable so it can embed inline in the email body
            $photoPath = $this->customContent['attachment_path'] ?? null;

            $mail = new InternationalLecturerCustomMail(
                $lecturer,
                (string) ($this->customContent['subject'] ?? ''),
                (string) ($this->customContent['body'] ?? ''),
                (bool) ($this->customContent['include_consent_button'] ?? false),
                $this->customContent['button_text'] ?? null,
                $photoPath,
            );
        } else {
            $mail = new InternationalLecturerInvitationMail($lecturer, $this->languageMode);
        }

        return $mail;
    }

    /**
     * Tangani kegagalan permanen setelah semua percobaan retries habis.
     */
    public function failed(?Throwable $exception): void
    {
        $lecturer = DosenInternasional::find($this->lecturerId);
        $log = $this->logId ? InternationalLecturerEmailLog::find($this->logId) : null;
        $errorMsg = $exception ? $exception->getMessage() : 'Gagal mengirim email (retries habis).';

        $lecturer?->update([
            'email_status' => 'failed',
            'email_error' => $errorMsg,
        ]);

        $log?->update([
            'status' => 'failed',
            'error' => $errorMsg,
        ]);
    }
}
