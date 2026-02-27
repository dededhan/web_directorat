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
     */
    public function isEditable(): bool
    {
        // Editable when: belum_diisi or draft, OR admin has set perbaikan
        return in_array($this->status, ['belum_diisi', 'draft'])
            || $this->admin_status === 'perbaikan';
    }
}
