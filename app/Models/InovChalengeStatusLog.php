<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeStatusLog extends Model
{
    use HasFactory;

    protected $table = 'inov_chalenge_status_logs';

    protected $guarded = ['id'];

    // ── Relations ──────────────────────────────────────────

    public function submission()
    {
        return $this->belongsTo(InovChalengeSubmission::class, 'inov_chalenge_submission_id');
    }

    public function tahap()
    {
        return $this->belongsTo(InovChalengeTahap::class, 'inov_chalenge_tahap_id');
    }

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    // ── Helpers ────────────────────────────────────────────

    /**
     * Create a status log entry for a tahap status change.
     */
    public static function logTahapStatus(
        int $submissionId,
        int $tahapId,
        ?string $from,
        string $to,
        ?string $keterangan = null,
        ?int $causerId = null,
        string $causerRole = 'system'
    ): self {
        return static::create([
            'inov_chalenge_submission_id' => $submissionId,
            'inov_chalenge_tahap_id'      => $tahapId,
            'tipe'                        => 'tahap',
            'status_dari'                 => $from,
            'status_ke'                   => $to,
            'keterangan'                  => $keterangan,
            'causer_id'                   => $causerId,
            'causer_role'                 => $causerRole,
        ]);
    }

    /**
     * Create a status log entry for the overall submission status change.
     */
    public static function logSubmissionStatus(
        int $submissionId,
        ?string $from,
        string $to,
        ?string $keterangan = null,
        ?int $causerId = null,
        string $causerRole = 'system'
    ): self {
        return static::create([
            'inov_chalenge_submission_id' => $submissionId,
            'inov_chalenge_tahap_id'      => null,
            'tipe'                        => 'submission',
            'status_dari'                 => $from,
            'status_ke'                   => $to,
            'keterangan'                  => $keterangan,
            'causer_id'                   => $causerId,
            'causer_role'                 => $causerRole,
        ]);
    }

    /**
     * Human-readable label for the status.
     */
    public function getStatusLabel(string $status): string
    {
        $labels = [
            // Tahap dosen status
            'belum_diisi'  => 'Belum Diisi',
            'draft'        => 'Draft',
            'diajukan'     => 'Diajukan',
            // Tahap admin status
            'menunggu'     => 'Menunggu Review',
            'disetujui'    => 'Disetujui',
            'perbaikan'    => 'Perbaikan Diperlukan',
            'selesai'      => 'Selesai',
            // Submission status
            'menunggu_direview'        => 'Menunggu Direview',
            'sedang_direview'          => 'Sedang Direview',
            'perbaikan_diperlukan'     => 'Perbaikan Diperlukan',
            'proses_tahap_selanjutnya' => 'Proses Tahap Selanjutnya',
        ];

        return $labels[$status] ?? ucwords(str_replace('_', ' ', $status));
    }

    /**
     * Icon for the status.
     */
    public function getStatusIcon(): string
    {
        return match ($this->status_ke) {
            'draft'                    => 'fa-edit',
            'diajukan'                 => 'fa-paper-plane',
            'menunggu', 'menunggu_direview' => 'fa-clock',
            'sedang_direview'          => 'fa-search',
            'disetujui'                => 'fa-check-circle',
            'perbaikan', 'perbaikan_diperlukan' => 'fa-redo',
            'selesai'                  => 'fa-flag-checkered',
            'proses_tahap_selanjutnya' => 'fa-forward',
            'belum_diisi'              => 'fa-circle',
            default                    => 'fa-info-circle',
        };
    }

    /**
     * Color for the status badge.
     */
    public function getStatusColor(): string
    {
        return match ($this->status_ke) {
            'draft'                    => 'yellow',
            'diajukan'                 => 'blue',
            'menunggu', 'menunggu_direview' => 'gray',
            'sedang_direview'          => 'purple',
            'disetujui'                => 'green',
            'perbaikan', 'perbaikan_diperlukan' => 'orange',
            'selesai'                  => 'teal',
            'proses_tahap_selanjutnya' => 'cyan',
            default                    => 'gray',
        };
    }
}
