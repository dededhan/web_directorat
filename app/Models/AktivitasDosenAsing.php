<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasDosenAsing extends Model
{
    use HasFactory;

    protected $table = 'aktivitas_dosen_asing';

    protected $fillable = [
        'dosen_internasional_id',
        'tanggal',
        'judul',
        'jenis_kegiatan',
        'isi',
        'keterangan',
        'link_bukti_kegiatan',
        'gambar',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function lecturer()
    {
        return $this->belongsTo(DosenInternasional::class, 'dosen_internasional_id');
    }
}
