<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChallengeReview extends Model
{
    use HasFactory;

    protected $table = 'inov_challenge_reviews';

    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'phase',
        'score',
        'feedback',
        'review_criteria',
        'status',
        'assigned_at',
        'reviewed_at',
    ];

    protected $casts = [
        'review_criteria' => 'array',
        'score'           => 'decimal:2',
        'assigned_at'     => 'datetime',
        'reviewed_at'     => 'datetime',
    ];

    // Relationships

    public function submission()
    {
        return $this->belongsTo(InovChallengeSubmission::class, 'submission_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
