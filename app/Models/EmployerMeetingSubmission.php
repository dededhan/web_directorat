<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerMeetingSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pengunggah',
        'proposal_path',
        'status',
        'is_confirmed',
        'catatan_admin',
        'bukti_keuangan_path',
        'laporan_kegiatan_path',
        'nama_calon_responden',
        'nama_qs_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}