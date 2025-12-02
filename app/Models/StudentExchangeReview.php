<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExchangeReview extends Model
{
    use HasFactory;

    protected $table = 'student_exchange_reviews';

    protected $fillable = [
        'proposal_student_exchange_id',
        'student_exchange_sub_chapter_id',
        'reviewer_id',
        'komentar',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'integer',
    ];

    /**
     * Get the proposal this review is for.
     */
    public function proposal()
    {
        return $this->belongsTo(ProposalStudentExchange::class, 'proposal_student_exchange_id');
    }

    /**
     * Get the sub-chapter this review is for.
     */
    public function subChapter()
    {
        return $this->belongsTo(StudentExchangeSubChapter::class, 'student_exchange_sub_chapter_id');
    }

    /**
     * Get the reviewer who created this review.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
