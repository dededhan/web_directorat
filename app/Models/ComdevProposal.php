<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevProposal extends Model
{
    use HasFactory;
    
    // Jika nama tabel Anda adalah 'proposal_sessions' (jamak), tambahkan baris ini.
    // Jika nama tabel Anda 'comdev_proposals', baris ini tidak perlu.
    protected $table = 'proposal_sessions';

    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'dana_maksimal',
        'periode_awal',
        'periode_akhir',
        'min_anggota',
        'max_anggota',
    ];
}