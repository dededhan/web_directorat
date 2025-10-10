<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulReview extends Model
{
    use HasFactory;
    
    protected $table = 'modul_reviews';
    
    protected $fillable = [
        'proposal_modul_id',
        'modul_sub_chapter_id',
        'reviewer_id',
        'komentar',
        'nilai',
    ];
    
    public function proposal()
    {
        return $this->belongsTo(ProposalModul::class, 'proposal_modul_id');
    }
    
    public function subChapter()
    {
        return $this->belongsTo(ModulSubChapter::class, 'modul_sub_chapter_id');
    }
    
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
