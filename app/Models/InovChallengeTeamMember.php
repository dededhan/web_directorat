<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChallengeTeamMember extends Model
{
    use HasFactory;

    protected $table = 'inov_challenge_team_members';

    protected $fillable = [
        'submission_id',
        'user_id',
        'member_type',
        'role',
        'invitation_status',
        'invited_at',
        'responded_at',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    // Relationships
    public function submission()
    {
        return $this->belongsTo(InovChallengeSubmission::class, 'submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Helper methods
    public function isInternal()
    {
        return $this->member_type === 'internal';
    }

    public function isExternal()
    {
        return $this->member_type === 'external';
    }

    public function isPending()
    {
        return $this->invitation_status === 'pending';
    }

    public function isAccepted()
    {
        return $this->invitation_status === 'accepted';
    }

    public function isRejected()
    {
        return $this->invitation_status === 'rejected';
    }

    public function accept()
    {
        $this->invitation_status = 'accepted';
        $this->responded_at = now();
        $this->save();

        // Create notification for submission owner
        InovChallengeNotification::create([
            'user_id' => $this->submission->user_id,
            'submission_id' => $this->submission_id,
            'notification_type' => 'team_invitation_accepted',
            'message' => "{$this->user->name} has accepted your team invitation.",
        ]);

        return $this;
    }

    public function reject()
    {
        $this->invitation_status = 'rejected';
        $this->responded_at = now();
        $this->save();

        // Create notification for submission owner
        InovChallengeNotification::create([
            'user_id' => $this->submission->user_id,
            'submission_id' => $this->submission_id,
            'notification_type' => 'team_invitation_rejected',
            'message' => "{$this->user->name} has rejected your team invitation.",
        ]);

        return $this;
    }

    public function sendInvitation()
    {
        $this->invited_at = now();
        $this->save();

        // Create notification for invited user
        InovChallengeNotification::create([
            'user_id' => $this->user_id,
            'submission_id' => $this->submission_id,
            'notification_type' => 'team_invitation',
            'message' => "You have been invited to join the team for: {$this->submission->title}",
        ]);

        return $this;
    }
}
