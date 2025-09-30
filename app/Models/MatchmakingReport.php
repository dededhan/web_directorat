<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchmakingReport extends Model
{
    use HasFactory;

    protected $table = 'matchmaking_reports';

    protected $fillable = [
        'matchmaking_submission_id',
        'proposal_path',
        'article_path',
        'journal_q1_name',
        'scimagojr_link',
        'submit_proof_path',
        'review_proof_path',
        'travel_proof_path',
                'setneg_approval_path',
        'visit_days',
        'qs_respondents',
    ];

    protected $casts = [
        'qs_respondents' => 'array',
    ];

    public function submission()
    {
        return $this->belongsTo(MatchmakingSubmission::class, 'matchmaking_submission_id');
    }
}
