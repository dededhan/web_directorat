<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChallengeSubmission extends Model
{
    use HasFactory;

    protected $table = 'inov_challenge_submissions';

    protected $fillable = [
        'session_id',
        'user_id',
        'title',
        'phase_1_data',
        'phase_1_status',
        'phase_1_submitted_at',
        'phase_2_data',
        'phase_2_status',
        'phase_2_submitted_at',
        'phase_3_data',
        'phase_3_status',
        'phase_3_submitted_at',
        'final_status',
    ];

    protected $casts = [
        'phase_1_data' => 'array',
        'phase_2_data' => 'array',
        'phase_3_data' => 'array',
        'phase_1_submitted_at' => 'datetime',
        'phase_2_submitted_at' => 'datetime',
        'phase_3_submitted_at' => 'datetime',
    ];

    // Relationships
    public function session()
    {
        return $this->belongsTo(InovChallengeSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // dosen leader
    }

    public function teamMembers()
    {
        return $this->hasMany(InovChallengeTeamMember::class, 'submission_id');
    }

    public function internalMembers()
    {
        return $this->teamMembers()->where('member_type', 'internal');
    }

    public function externalMembers()
    {
        return $this->teamMembers()->where('member_type', 'external');
    }

    public function acceptedMembers()
    {
        return $this->teamMembers()->where('invitation_status', 'accepted');
    }

    public function pendingMembers()
    {
        return $this->teamMembers()->where('invitation_status', 'pending');
    }

    public function uploads()
    {
        return $this->hasMany(InovChallengeUpload::class, 'submission_id');
    }

    public function uploadsByPhase($phase)
    {
        return $this->uploads()->where('phase', $phase);
    }

    public function reviews()
    {
        return $this->hasMany(InovChallengeReview::class, 'submission_id');
    }

    public function reviewsByPhase($phase)
    {
        return $this->reviews()->where('phase', $phase);
    }

    public function notifications()
    {
        return $this->hasMany(InovChallengeNotification::class, 'submission_id');
    }

    // Helper methods
    public function getCurrentPhase()
    {
        if ($this->phase_1_status !== 'approved') {
            return 'phase_1';
        } elseif ($this->phase_2_status !== 'approved') {
            return 'phase_2';
        } elseif ($this->phase_3_status !== 'approved') {
            return 'phase_3';
        }
        return 'completed';
    }

    public function canEditPhase($phase)
    {
        $statusMap = [
            'phase_1' => $this->phase_1_status,
            'phase_2' => $this->phase_2_status,
            'phase_3' => $this->phase_3_status,
        ];

        $status = $statusMap[$phase] ?? null;
        return in_array($status, ['draft', 'rejected']);
    }

    public function canSubmitPhase($phase)
    {
        return $this->canEditPhase($phase);
    }

    public function isPhaseApproved($phase)
    {
        $statusMap = [
            'phase_1' => $this->phase_1_status,
            'phase_2' => $this->phase_2_status,
            'phase_3' => $this->phase_3_status,
        ];

        return ($statusMap[$phase] ?? null) === 'approved';
    }

    public function getAverageScoreForPhase($phase)
    {
        return $this->reviewsByPhase($phase)->avg('score');
    }

    public function hasReviewerForPhase($phase, $reviewerId)
    {
        return $this->reviewsByPhase($phase)
            ->where('reviewer_id', $reviewerId)
            ->exists();
    }
}
