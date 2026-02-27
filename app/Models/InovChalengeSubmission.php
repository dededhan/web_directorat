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
}
