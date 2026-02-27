<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChallengeNotification extends Model
{
    use HasFactory;

    protected $table = 'inov_challenge_notifications';

    protected $fillable = [
        'user_id',
        'submission_id',
        'notification_type',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function submission()
    {
        return $this->belongsTo(InovChallengeSubmission::class, 'submission_id');
    }

    // Helper methods
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->save();
        }
        return $this;
    }

    public function markAsUnread()
    {
        $this->is_read = false;
        $this->read_at = null;
        $this->save();
        return $this;
    }

    public static function createForUser($userId, $submissionId, $type, $message)
    {
        return self::create([
            'user_id' => $userId,
            'submission_id' => $submissionId,
            'notification_type' => $type,
            'message' => $message,
        ]);
    }

    public static function notifyTeamInvitation($teamMemberId)
    {
        $teamMember = InovChallengeTeamMember::find($teamMemberId);
        if ($teamMember) {
            return self::createForUser(
                $teamMember->user_id,
                $teamMember->submission_id,
                'team_invitation',
                "You have been invited to join the team for: {$teamMember->submission->title}"
            );
        }
        return null;
    }

    public static function notifyReviewAssigned($reviewId)
    {
        $review = InovChallengeReview::find($reviewId);
        if ($review) {
            return self::createForUser(
                $review->reviewer_id,
                $review->submission_id,
                'review_assigned',
                "You have been assigned to review '{$review->submission->title}' for {$review->phase}"
            );
        }
        return null;
    }

    public static function notifyStatusUpdate($submissionId, $phase, $status)
    {
        $submission = InovChallengeSubmission::find($submissionId);
        if ($submission) {
            $statusMessage = ucfirst(str_replace('_', ' ', $status));
            return self::createForUser(
                $submission->user_id,
                $submissionId,
                'status_update',
                "Your submission '{$submission->title}' for {$phase} has been {$statusMessage}"
            );
        }
        return null;
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('notification_type', $type);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }
}
