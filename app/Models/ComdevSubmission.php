<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevSubmission extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $casts = [
        'kata_kunci' => 'array',
        'sdgs' => 'array',
        'mitra_nasional' => 'array',
        'mitra_internasional' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sesi()
    {
        return $this->belongsTo(ComdevProposal::class, 'comdev_proposal_id');
    }

    public function members()
    {
        return $this->hasMany(ProposalMember::class);
    }
    
    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'comdev_submission_reviewer', 'comdev_submission_id', 'reviewer_id');
    }

    public function files()
    {
        return $this->hasMany(ComdevSubmissionFile::class, 'comdev_submission_id');
    }

    
    public function reviews()
    {
        return $this->hasMany(ComdevReview::class, 'comdev_submission_id');
    }
    
    public function moduleStatuses()
    {
        return $this->hasMany(ComdevSubmissionModuleStatus::class, 'comdev_submission_id');
    }

}
