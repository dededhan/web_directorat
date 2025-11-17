<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalModul extends Model
{
    use HasFactory;
    
    protected $table = 'proposal_modul';
    
    protected $guarded = ['id'];
    
    protected $casts = [
        'kata_kunci' => 'array',
        'sdgs' => 'array',
        'sdgs_fokus' => 'array',
        'sdgs_pendukung' => 'array',
        'nominal_hibah' => 'decimal:2',
        'anggaran_usulan' => 'decimal:2',
    ];
    
    public function sesi()
    {
        return $this->belongsTo(SesiHibahModul::class, 'sesi_hibah_modul_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
    
    public function anggota()
    {
        return $this->hasMany(AnggotaPenyusun::class, 'proposal_modul_id')->orderBy('urutan');
    }
    
    public function files()
    {
        return $this->hasMany(ModulSubmissionFile::class, 'proposal_modul_id');
    }
    
    public function reviews()
    {
        return $this->hasMany(ModulReview::class, 'proposal_modul_id');
    }
    
    public function reviewerAssignments()
    {
        return $this->hasMany(ReviewerHibahAssignment::class, 'proposal_modul_id');
    }
}
