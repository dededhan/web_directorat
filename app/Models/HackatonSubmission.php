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

    public function identitasIsComplete(): bool
    {
        return $this->identitas !== null
            && filled($this->identitas->nama_produk)
            && filled($this->identitas->skema_inovasi)
            && filled($this->identitas->bidang_utama_produk)
            && $this->members()->where('peran', '!=', 'Ketua')->count() >= 1;
    }
}
