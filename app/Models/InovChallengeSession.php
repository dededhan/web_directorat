<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChallengeSession extends Model
{
    use HasFactory;

    protected $table = 'inov_challenge_sessions';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'registration_deadline',
        'status',
        'max_participants',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_deadline' => 'date',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions()
    {
        return $this->hasMany(InovChallengeSubmission::class, 'session_id');
    }

    public function formBuilders()
    {
        return $this->hasMany(InovChallengeFormBuilder::class, 'session_id');
    }

    // Helper methods
    public function getFormByPhase($phase)
    {
        return $this->formBuilders()->where('phase', $phase)->first();
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isClosed()
    {
        return $this->status === 'closed';
    }

    public function canRegister()
    {
        return $this->status === 'active' && now()->lte($this->registration_deadline);
    }
}
