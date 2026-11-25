<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Throwable;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email : Alamat email penerima untuk uji coba kirim}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email uji coba untuk memverifikasi konfigurasi SMTP/Mailer';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $recipient = $this->argument('email');

        if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            $this->error("Alamat email tidak valid: {$recipient}");
            return Command::FAILURE;
        }

        $mailer = config('mail.default');
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        $smtpConfig = config("mail.mailers.{$mailer}", []);

        $this->info('========================================================');
        $this->info('  Uji Coba Konfigurasi Email / SMTP (Mail Diagnostics)  ');
        $this->info('========================================================');
        $this->line("Mailer Driver : <comment>{$mailer}</comment>");
        $this->line("Host / Port   : <comment>" . ($smtpConfig['host'] ?? '-') . ':' . ($smtpConfig['port'] ?? '-') . "</comment>");
        $this->line("Username      : <comment>" . ($smtpConfig['username'] ?? '(kosong)') . "</comment>");
        $this->line("From Address  : <comment>{$fromAddress}</comment>");
        $this->line("From Name     : <comment>{$fromName}</comment>");
        $this->line("Penerima Test : <comment>{$recipient}</comment>");
        $this->info('--------------------------------------------------------');
        $this->line('Mengirim email uji coba langsung (tanpa antrean)...');

        $startTime = microtime(true);

        try {
            Mail::raw("Halo!\n\nIni adalah email uji coba dari sistem web Direktorat Universitas Negeri Jakarta.\n\nJika Anda menerima email ini, berarti konfigurasi SMTP aplikasi Laravel telah berfungsi dengan baik dan siap digunakan untuk pengiriman email ke dosen internasional.\n\nWaktu pengiriman: " . now()->format('d M Y H:i:s T') . "\n\nSalam,\n{$fromName}", function ($message) use ($recipient, $fromAddress, $fromName) {
                $message->to($recipient)
                    ->subject('[TEST] Uji Coba Konfigurasi Email - Universitas Negeri Jakarta');
            });

            $duration = round(microtime(true) - $startTime, 2);

            $this->newLine();
            $this->info("✔ [BERHASIL] Email uji coba sukses terkirim ke {$recipient} dalam {$duration} detik!");
            $this->line('Silakan periksa kotak masuk (inbox) atau folder spam penerima.');
            $this->info('========================================================');

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $duration = round(microtime(true) - $startTime, 2);

            $this->newLine();
            $this->error("✖ [GAGAL] Pengiriman email uji coba gagal setelah {$duration} detik!");
            $this->newLine();
            $this->line('<fg=red>Pesan Error:</>');
            $this->line($e->getMessage());
            $this->newLine();
            $this->line('<fg=yellow>Saran Perbaikan:</>');
            $this->line('1. Pastikan MAIL_HOST, MAIL_PORT, MAIL_USERNAME, dan MAIL_PASSWORD di file .env sudah benar.');
            $this->line('2. Jika menggunakan Gmail, buat "App Password" (bukan password akun biasa) dan aktifkan 2FA.');
            $this->line('3. Pastikan port (587 untuk TLS atau 465 untuk SSL) tidak diblokir oleh firewall hosting/jaringan.');
            $this->line('4. Jika menggunakan server kampus/Zimbra/cPanel, pastikan port dan SSL cert valid.');
            $this->info('========================================================');

            return Command::FAILURE;
        }
    }
}

