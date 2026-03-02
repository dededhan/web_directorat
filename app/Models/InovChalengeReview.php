<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeReview extends Model
{
    use HasFactory;

    protected $table = 'inov_chalenge_reviews';

    protected $guarded = ['id'];

    protected $casts = [
        'skor' => 'integer',
    ];

    /**
     * Get the color class for the score badge.
     */
    public function getSkorColor(): string
    {
        if ($this->skor === null) return 'bg-gray-100 text-gray-500';
        if ($this->skor >= 80) return 'bg-green-100 text-green-700';
        if ($this->skor >= 60) return 'bg-cyan-100 text-cyan-700';
        if ($this->skor >= 40) return 'bg-yellow-100 text-yellow-700';
        return 'bg-red-100 text-red-700';
    }

    /**
     * Get the gradient color for the score bar.
     */
    public function getSkorBarColor(): string
    {
        if ($this->skor === null) return 'from-gray-300 to-gray-400';
        if ($this->skor >= 80) return 'from-green-400 to-green-600';
        if ($this->skor >= 60) return 'from-cyan-400 to-cyan-600';
        if ($this->skor >= 40) return 'from-yellow-400 to-yellow-600';
        return 'from-red-400 to-red-600';
    }

    public function submission()
    {
        return $this->belongsTo(InovChalengeSubmission::class, 'inov_chalenge_submission_id');
    }

    public function tahap()
    {
        return $this->belongsTo(InovChalengeTahap::class, 'inov_chalenge_tahap_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
