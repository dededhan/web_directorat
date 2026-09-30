<?php

namespace App\Models;

use App\Enums\HackatonStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonSubmission extends Model
{
    use HasFactory;

    protected $table = 'hackaton_submissions';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => HackatonStatusEnum::class,
    ];

    public const KATEGORI_DFARM = 'd-farm';
    public const KATEGORI_DTECH = 'd-tech';

    public const KATEGORI_LABELS = [
        self::KATEGORI_DFARM => 'D-FARM',
        self::KATEGORI_DTECH => 'D-TECH',
    ];

    public const TEMAS = [
        'D-FARM' => 'D-FARM (DeepTech Food Acceleration Research to Market)',
        'D-TECH' => 'D-TECH (DeepTech Acceleration Research to Challenge)',
        'D-MARC' => 'D-TECH (DeepTech Medical & Technology Acceleration / D-MARC)',
    ];

    public function getKategoriLabelAttribute(): string
    {
        return self::KATEGORI_LABELS[$this->kategori] ?? ($this->kategori ? strtoupper($this->kategori) : '-');
    }

    public function getTemaLabelAttribute()
    {
        if (!$this->tema) return null;
        return self::TEMAS[$this->tema] ?? $this->tema;
    }

    public function session()
    {
        return $this->belongsTo(HackatonSession::class, 'hackaton_session_id');
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
        return $this->hasMany(HackatonSubmissionTahap::class, 'hackaton_submission_id');
    }

    public function members()
    {
        return $this->hasMany(HackatonSubmissionMember::class, 'hackaton_submission_id');
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'hackaton_submission_reviewer', 'hackaton_submission_id', 'user_id')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(HackatonReview::class, 'hackaton_submission_id');
    }

    public function identitas()
    {
        return $this->hasOne(HackatonSubmissionIdentitas::class, 'hackaton_submission_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(HackatonStatusLog::class, 'hackaton_submission_id')
            ->orderByDesc('created_at');
    }

    public function progressLogs()
    {
        return $this->hasMany(HackatonProgressLog::class, 'hackaton_submission_id')
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at');
    }

    public function identitasIsComplete(): bool
    {
        return $this->identitas !== null
            && filled($this->identitas->nama_produk)
            && filled($this->identitas->skema_inovasi)
            && filled($this->identitas->bidang_utama_produk)
            && $this->members()->where('peran', '!=', 'Ketua')->count() >= 1;
    }

    /**
     * Check if a user is the owner (Ketua) or an active member of this submission.
     */
    public function canUserEdit(?int $userId = null): bool
    {
        $userId = $userId ?: auth()->id();
        if (!$userId) {
            return false;
        }

        // Owner (Ketua pengusul)
        if ($this->user_id === $userId) {
            return true;
        }

        // Active / approved team member
        return $this->members()
            ->where('user_id', $userId)
            ->whereIn('approval_status', ['approved', 'not_required'])
            ->exists();
    }

    /**
     * Check if a user can view this submission.
     */
    public function canUserView(?int $userId = null): bool
    {
        $userId = $userId ?: auth()->id();
        if (!$userId) {
            return false;
        }

        if ($this->user_id === $userId) {
            return true;
        }

        if ($this->members()->where('user_id', $userId)->exists()) {
            return true;
        }

        if ($this->reviewers()->where('users.id', $userId)->exists()) {
            return true;
        }

        return false;
    }
}
