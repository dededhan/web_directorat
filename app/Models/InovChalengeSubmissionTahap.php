<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeSubmissionTahap extends Model
{
    use HasFactory;

    protected $table = 'inov_chalenge_submission_tahap';

    protected $guarded = ['id'];

    protected $casts = [
        'submitted_at' => 'datetime',
        'nominal_evaluasi' => 'decimal:2',
    ];

    public function submission()
    {
        return $this->belongsTo(InovChalengeSubmission::class, 'inov_chalenge_submission_id');
    }

    public function tahap()
    {
        return $this->belongsTo(InovChalengeTahap::class, 'inov_chalenge_tahap_id');
    }

    public function fieldValues()
    {
        return $this->hasMany(InovChalengeFieldValue::class, 'inov_chalenge_tahap_id', 'inov_chalenge_tahap_id')
            ->where('inov_chalenge_submission_id', $this->inov_chalenge_submission_id);
    }

    /**
     * Check if this tahap is editable by dosen.
     * Considers both status + tahap timing period.
     */
    public function isEditable(): bool
    {
        $statusOk = in_array($this->status, ['belum_diisi', 'draft'])
            || $this->admin_status === 'perbaikan';

        // Also check tahap timing — must be open (not upcoming, not closed)
        $tahap = $this->tahap;
        $timingOk = $tahap ? $tahap->isOpen() : true;

        // Gate: previous tahap must be "lolos" (disetujui/selesai) for tahap > 1
        $prevOk = $this->isPreviousTahapLolos();

        return $statusOk && $timingOk && $prevOk;
    }

    /**
     * Check if the previous tahap (tahap_ke - 1) has been declared lolos
     * (admin_status = disetujui or selesai). Always true for tahap_ke = 1.
     */
    public function isPreviousTahapLolos(): bool
    {
        $tahap = $this->tahap;
        if (!$tahap || $tahap->tahap_ke <= 1) {
            return true; // Tahap 1 has no prerequisite
        }

        // Find the previous tahap definition in the same session
        $previousTahap = InovChalengeTahap::where('inov_chalenge_session_id', $tahap->inov_chalenge_session_id)
            ->where('tahap_ke', $tahap->tahap_ke - 1)
            ->first();

        if (!$previousTahap) {
            return true; // No previous tahap exists
        }

        // Find the dosen's submission_tahap row for that previous tahap
        $previousSubmissionTahap = self::where('inov_chalenge_submission_id', $this->inov_chalenge_submission_id)
            ->where('inov_chalenge_tahap_id', $previousTahap->id)
            ->first();

        if (!$previousSubmissionTahap) {
            return false;
        }

        return in_array($previousSubmissionTahap->admin_status, ['disetujui', 'selesai']);
    }

    /**
     * Get a unified tracking status that combines submission_tahap.status,
     * admin_status, and reviewer assignment into a single display state.
     *
     * Returns: ['key' => string, 'label' => string, 'color' => string, 'icon' => string]
     */
    public function getTrackingStatus(bool $hasReviewer = false): array
    {
        $tahapKe = $this->tahap->tahap_ke ?? '?';

        if ($this->status === 'belum_diisi') {
            return [
                'key'   => 'belum_diisi',
                'label' => "Tahap {$tahapKe}: Menunggu Pengisian",
                'short' => 'Menunggu Pengisian',
                'color' => 'gray',
                'icon'  => 'fa-hourglass-start',
            ];
        }

        if ($this->status === 'draft') {
            return [
                'key'   => 'draft',
                'label' => "Tahap {$tahapKe}: Draft",
                'short' => 'Draft',
                'color' => 'yellow',
                'icon'  => 'fa-edit',
            ];
        }

        // status = diajukan
        if ($this->admin_status === 'perbaikan') {
            return [
                'key'   => 'perbaikan',
                'label' => "Tahap {$tahapKe}: Perbaikan Diperlukan",
                'short' => 'Perbaikan Diperlukan',
                'color' => 'orange',
                'icon'  => 'fa-redo',
            ];
        }

        if ($this->admin_status === 'disetujui' || $this->admin_status === 'selesai') {
            return [
                'key'   => 'lolos',
                'label' => "Lolos Tahap {$tahapKe}",
                'short' => 'Lolos',
                'color' => 'green',
                'icon'  => 'fa-check-circle',
            ];
        }

        // admin_status = menunggu
        if ($hasReviewer) {
            return [
                'key'   => 'sedang_direview',
                'label' => "Tahap {$tahapKe}: Sedang Direview",
                'short' => 'Sedang Direview',
                'color' => 'purple',
                'icon'  => 'fa-search',
            ];
        }

        return [
            'key'   => 'diajukan',
            'label' => "Tahap {$tahapKe}: Diajukan",
            'short' => 'Diajukan',
            'color' => 'blue',
            'icon'  => 'fa-paper-plane',
        ];
    }
}
