<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewerHibahAssignment extends Model
{
    use HasFactory;
    
    protected $table = 'reviewer_hibah_assignment';
    
    protected $fillable = [
        'proposal_modul_id',
        'reviewer_id',
        'assigned_at',
        'reviewed_at',
    ];
    
    protected $casts = [
        'assigned_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];
    
    public function proposal()
    {
        return $this->belongsTo(ProposalModul::class, 'proposal_modul_id');
    }
    
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
