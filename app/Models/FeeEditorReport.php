<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeEditorReport extends Model
{
    use HasFactory;

    // Sesuaikan fillable dengan kolom di tabel fee_editor_reports
    protected $fillable = [
        'fee_editor_session_id',
        'user_id',
        'nama_jurnal',
        'link_scimagojr',
        'peran',
        'penugasan_awal',
        'penugasan_akhir',
        'bukti_undangan_path',
        'link_laman_resmi',
        'bukti_aktivitas_path',
        'status',
    ];

    // Relasi: Satu Laporan Editor MILIK SATU Sesi Editor
    public function session()
    {
        return $this->belongsTo(FeeEditorSession::class, 'fee_editor_session_id');
    }

    // Relasi: Satu Laporan Editor MILIK SATU User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}