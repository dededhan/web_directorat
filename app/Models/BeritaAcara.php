<?php

// app/Models/BeritaAcara.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    protected $table = 'berita_acara';
    use HasFactory;

    protected $fillable = [
        'hari',
        'tanggal',
        'bulan',
        'tahun',
        'tempat',
        'surat_keputusan',
        'judul_inovasi',
        'jenis_inovasi',
        'nilai_tki',
        'opini_penilai',
        'tanggal_penutupan',
        'ttd_penanggungjawab',
        'nama_penanggungjawab',
        'ttd_ketua_tim',
        'nama_ketua_tim',
        'ttd_anggota1',
        'nama_anggota1',
        'ttd_anggota2',
        'nama_anggota2'
    ];

    protected $casts = [
        'tanggal_penutupan' => 'date:Y-m-d',
        'nilai_tki' => 'decimal:2'
    ];
}