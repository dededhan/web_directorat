<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MatchmakingSubmission extends Model
{
    use HasFactory;

    protected $table = 'matchmaking_submissions';

    protected $fillable = [
        'matchmaking_session_id',
        'user_id',
        'judul_proposal',
        'status',
        'rejection_note',
        'status_history',
    ];


    protected $casts = [
        'status_history' => 'array',
    ];

    public function addStatusLog(string $newStatus, ?string $notes = null): void
    {
        $history = $this->status_history ?? [];
        
        $logEntry = [
            'status' => $newStatus,
            'timestamp' => Carbon::now()->toIso8601String(),
            'notes' => $notes,
            'changed_by' => auth()->check() ? auth()->id() : null,
        ];

        $history[] = $logEntry;

        $this->attributes['status_history'] = json_encode($history);
        $this->save();
    }


    /**
     * Relasi many-to-one: Satu submission dimiliki oleh satu session.
     */
    public function session()
    {
        return $this->belongsTo(MatchmakingSession::class, 'matchmaking_session_id');
    }

    /**
     * Relasi many-to-one: Satu submission dimiliki oleh satu user (dosen ketua).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi one-to-many: Satu submission memiliki banyak members.
     */
    public function members()
    {
        return $this->hasMany(MatchmakingMember::class);
    }

    /**
     * Relasi one-to-one: Satu submission memiliki satu report.
     */
    public function report()
    {
        return $this->hasOne(MatchmakingReport::class);
    }
}

