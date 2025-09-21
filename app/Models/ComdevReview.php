<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevReview extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * ==========================================================
     * TAMBAHAN BARU: Relasi ke user yang menjadi reviewer.
     * ==========================================================
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
