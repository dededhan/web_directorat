<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\InovChalengeStatusEnum;

class InovChalengeSubmission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => InovChalengeStatusEnum::class,
    ];

    public function session()
    {
        return $this->belongsTo(InovChalengeSession::class, 'inov_chalenge_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function submissionTahap()
    {
        return $this->hasMany(InovChalengeSubmissionTahap::class, 'inov_chalenge_submission_id');
    }

    public function members()
    {
        return $this->hasMany(InovChalengeSubmissionMember::class, 'inov_chalenge_submission_id');
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'inov_chalenge_submission_reviewer', 'inov_chalenge_submission_id', 'reviewer_id')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(InovChalengeReview::class, 'inov_chalenge_submission_id');
    }

    public function identitas()
    {
        return $this->hasOne(InovChalengeSubmissionIdentitas::class, 'inov_chalenge_submission_id');
    }

    /**
     * Returns true when the identitas step is complete enough to unlock Tahap access.
     * Conditions:
     *  - identitas record exists
     *  - nama_produk, skema_inovasi, bidang_utama_produk are all non-empty
     *  - at least 1 member with peran != 'Ketua' (i.e. an actual anggota)
     */
    public function identitasIsComplete(): bool
    {
        return $this->identitas !== null
            && filled($this->identitas->nama_produk)
            && filled($this->identitas->skema_inovasi)
            && filled($this->identitas->bidang_utama_produk)
            && $this->members()->where('peran', '!=', 'Ketua')->count() >= 1;
    }
}
