<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevReview extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Melindungi dari mass assignment

    /**
     * Relasi: Review ini milik submission (proposal) mana.
     */
    public function submission()
    {
        return $this->belongsTo(ComdevSubmission::class, 'comdev_submission_id');
    }

    /**
     * Relasi: Review ini untuk sub-bab yang mana.
     */
    public function subChapter()
    {
        return $this->belongsTo(ComdevSubChapter::class, 'comdev_sub_chapter_id');
    }

    /**
     * Relasi: Review ini dibuat oleh user (reviewer) mana.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}