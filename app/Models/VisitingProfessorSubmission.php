<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitingProfessorSubmission extends Model
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
    ];

    /**
     * Get the user that owns the submission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}