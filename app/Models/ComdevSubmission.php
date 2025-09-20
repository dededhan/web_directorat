<?php
// File: app/Models/ComdevSubmission.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevSubmission extends Model
{
    use HasFactory;
    
    // Lindungi dari mass assignment
    protected $guarded = ['id'];

    // Cast kolom JSON ke array
    protected $casts = [
        'kata_kunci' => 'array',
        'sdgs' => 'array',
        'mitra_nasional' => 'array',
        'mitra_internasional' => 'array',
    ];

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Relasi: Submission ini milik Sesi Proposal mana.
     */
    public function sesi()
    {
        return $this->belongsTo(ComdevProposal::class, 'comdev_proposal_id');
    }

    
 public function reviewers()
    {
        // Argumen 1: Model yang dihubungkan (User)
        // Argumen 2: Nama tabel pivot/perantara
        // Argumen 3: Foreign key untuk model ini di tabel pivot
        // Argumen 4: Foreign key untuk model User di tabel pivot
        return $this->belongsToMany(User::class, 'comdev_submission_reviewer', 'comdev_submission_id', 'reviewer_id');
    }
    /**
     * Relasi: Submission ini memiliki banyak anggota.
     */
    public function members()
    {
        return $this->hasMany(ProposalMember::class);
    }
}