<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ComdevStatusEnum;

class ComdevSubmission extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $casts = [
        'status' => ComdevStatusEnum::class,
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
    public function activeModuleStatus()
    {
        return $this->hasOne(ComdevSubmissionModuleStatus::class, 'comdev_submission_id')
            ->join('comdev_modules', 'comdev_submission_module_statuses.comdev_module_id', '=', 'comdev_modules.id')
            ->where('comdev_submission_module_statuses.status', '!=', 'lolos')
            ->orderBy('comdev_modules.urutan', 'asc');
    }
    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'comdev_submission_id')->orderBy('activity_date', 'desc');
    }

}
