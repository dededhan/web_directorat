<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggotaPenyusun extends Model
{
    use HasFactory;
    
    protected $table = 'anggota_penyusun';
    
    protected $fillable = [
        'proposal_modul_id',
        'nama_dosen',
        'nip',
        'fakultas',
        'prodi',
        'urutan',
    ];
    
    public function proposal()
    {
        return $this->belongsTo(ProposalModul::class, 'proposal_modul_id');
    }
}
