<?php

namespace App\Jobs;

use App\Mail\InternationalLectureGreetingMail;
use App\Models\InternationalLectureGreeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendInternationalLectureGreeting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;
    public int $backoff = 10;

    public function __construct(public int $greetingId) {}

    public function handle(): void
    {
        $greeting = InternationalLectureGreeting::find($this->greetingId);
        if (!$greeting || !$greeting->recipient_email) {
            return;
        }

        $greeting->update([
            'email_status' => 'sending',
            'email_error' => null,
        ]);

        try {
            Mail::to($greeting->recipient_email)->send(
                new InternationalLectureGreetingMail($greeting)
            );

            $greeting->update([
                'email_status' => 'sent',
                'email_sent_at' => now(),
                'email_error' => null,
            ]);
        } catch (Throwable $e) {
            $greeting->update([
                'email_status' => 'failed',
                'email_error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(?Throwable $exception): void
    {
        $greeting = InternationalLectureGreeting::find($this->greetingId);
        $errorMsg = $exception ? $exception->getMessage() : 'Gagal mengirim email (retries habis).';

        $greeting?->update([
            'email_status' => 'failed',
            'email_error' => $errorMsg,
        ]);
    }
}
