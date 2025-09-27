<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchmakingMember extends Model
{
    use HasFactory;

    protected $table = 'matchmaking_members';

    protected $fillable = [
        'matchmaking_submission_id',
        'type',
        'user_id',
        'details',
    ];


    protected $casts = [
        'details' => 'array',
    ];

 
    public function submission()
    {
        return $this->belongsTo(MatchmakingSubmission::class, 'matchmaking_submission_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
