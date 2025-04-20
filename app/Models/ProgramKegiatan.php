<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKegiatan extends Model
{
    use HasFactory;

    protected $table = 'program_kegiatan';

    protected $fillable = [
        'judul',
        'tanggal',
        'kategori',
        'deskripsi',
        'nama_gambar',
        'nama_gambar_hash',
        'path_gambar',
        'ukuran_gambar',
        'ekstensi_gambar'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get the category label
     */
    public function getKategoriLabelAttribute()
    {
        return match($this->kategori) {
            'penelitian' => 'Penelitian',
            'pengabdian_masyarakat' => 'Pengabdian Masyarakat',
            'pendidikan' => 'Pendidikan',
            'kolaborasi' => 'Kolaborasi',
            default => 'Unknown',
        };
    }
}