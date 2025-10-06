<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentingReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'presenting_session_id',
        'user_id',
        'nama_conference',
        'penyelenggaraan_ke',
        'lembaga_penyelenggara',
        'link_website',
        'tempat_pelaksanaan',
        'negara_pelaksanaan',
        'waktu_pelaksanaan_awal',
        'waktu_pelaksanaan_akhir',
        'judul_artikel',
        'sdg_terkait',
        'keywords_sdg',
        'bukti_pendaftaran_path',
        'bukti_loa_path',
        'rencana_anggaran',
        'status',
        'status_note',
    ];

    protected $casts = [
        'waktu_pelaksanaan_awal' => 'date',
        'waktu_pelaksanaan_akhir' => 'date',
    ];

    protected $appends = ['computed_status'];

    public function getComputedStatusAttribute()
    {
        return $this->status;
    }

    // Satu Laporan MILIK SATU Sesi
    public function session()
    {
        return $this->belongsTo(PresentingSession::class, 'presenting_session_id');
    }

    // Satu Laporan MILIK SATU User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Satu Laporan PUNYA SATU Submission
    public function submission()
    {
        return $this->hasOne(PresentingSubmission::class);
    }
}