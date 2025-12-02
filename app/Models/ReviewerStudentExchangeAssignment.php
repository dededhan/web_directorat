<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewerStudentExchangeAssignment extends Model
{
    use HasFactory;

    protected $table = 'reviewer_student_exchange_assignment';

    protected $fillable = [
        'reviewer_id',
        'proposal_student_exchange_id',
        'assigned_at',
        'reviewed_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the reviewer assigned.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Get the proposal assigned to the reviewer.
     */
    public function proposal()
    {
        return $this->belongsTo(ProposalStudentExchange::class, 'proposal_student_exchange_id');
    }

    /**
     * Check if review is completed.
     */
    public function isCompleted()
    {
        return !is_null($this->reviewed_at);
    }

    /**
     * Mark assignment as reviewed.
     */
    public function markAsReviewed()
    {
        $this->reviewed_at = now();
        $this->save();
    }
}
