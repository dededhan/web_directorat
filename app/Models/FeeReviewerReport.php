<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeReviewerReport extends Model
{
    use HasFactory;

    // Tentukan kolom mana saja yang boleh diisi
    protected $fillable = [
        'fee_reviewer_session_id',
        'user_id',
        'judul_artikel',
        'nama_jurnal',
        'link_scimagojr',
        'tanggal_review',
        'bukti_undangan_path',
        'bukti_hasil_review_path',
        'bukti_pengiriman_tepat_waktu_path',
        'bukti_lain_path',
        'surat_pernyataan_path',
        'status',
    ];

    // Definisikan relasi: Satu Laporan MILIK SATU Sesi
    public function session()
    {
        return $this->belongsTo(FeeReviewerSession::class, 'fee_reviewer_session_id');
    }

    // Definisikan relasi: Satu Laporan MILIK SATU User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}