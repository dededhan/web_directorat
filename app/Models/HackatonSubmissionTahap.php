<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonSubmissionTahap extends Model
{
    use HasFactory;

    protected $table = 'hackaton_submission_tahap';

    protected $guarded = ['id'];

    protected $casts = [
        'submitted_at' => 'datetime',
        'nominal_evaluasi' => 'decimal:2',
    ];

    public function submission()
    {
        return $this->belongsTo(HackatonSubmission::class, 'hackaton_submission_id');
    }

    public function tahap()
    {
        return $this->belongsTo(HackatonTahap::class, 'hackaton_tahap_id');
    }

    public function fieldValues()
    {
        return $this->hasMany(HackatonSubmissionFieldValue::class, 'hackaton_tahap_id', 'hackaton_tahap_id')
            ->where('hackaton_submission_id', $this->hackaton_submission_id);
    }

    public function isEditable(): bool
    {
        $statusOk = in_array($this->status, ['belum_diisi', 'draft'])
            || $this->admin_status === 'perbaikan';

        $tahap = $this->tahap;
        $timingOk = $tahap ? $tahap->isOpen() : true;
        $prevOk = $this->isPreviousTahapLolos();

        return $statusOk && $timingOk && $prevOk;
    }

    public function isPreviousTahapLolos(): bool
    {
        $tahap = $this->tahap;
        if (!$tahap || $tahap->tahap_ke <= 1) {
            return true;
        }

        $previousTahap = HackatonTahap::where('hackaton_session_id', $tahap->hackaton_session_id)
            ->where('tahap_ke', $tahap->tahap_ke - 1)
            ->first();

        if (!$previousTahap) {
            return true;
        }

        $previousSubmissionTahap = self::where('hackaton_submission_id', $this->hackaton_submission_id)
            ->where('hackaton_tahap_id', $previousTahap->id)
            ->first();

        if (!$previousSubmissionTahap) {
            return false;
        }

        return in_array($previousSubmissionTahap->admin_status, ['disetujui', 'selesai']);
    }

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
