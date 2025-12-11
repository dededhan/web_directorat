<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HibahModulReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_modul_id',
        'hibah_modul_akhir_id',
        'reviewer_id',
        'nilai',
        'komentar',
        'status_review',
    ];

    protected $casts = [
        'nilai' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function proposal()
    {
        return $this->belongsTo(ProposalModul::class, 'proposal_modul_id');
    }

    public function modul()
    {
        return $this->belongsTo(HibahModulAkhir::class, 'hibah_modul_akhir_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
