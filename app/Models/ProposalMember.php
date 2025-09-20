<?php
// File: app/Models/ProposalMember.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalMember extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false; // Tabel ini tidak pakai timestamps

    /**
     * Relasi: Anggota ini milik Submission mana.
     */
    public function submission()
    {
        return $this->belongsTo(ComdevSubmission::class, 'comdev_submission_id');
    }
}