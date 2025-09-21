<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevModule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi: Modul ini milik Sesi Proposal mana.
     */
    public function sesi()
    {
        return $this->belongsTo(ComdevProposal::class, 'comdev_proposal_id');
    }

    /**
     * Relasi: Modul ini memiliki banyak Sub-Bab.
     * Diurutkan berdasarkan kolom 'urutan'.
     */
    public function subChapters()
    {
        return $this->hasMany(ComdevSubChapter::class)->orderBy('urutan');
    }
}
