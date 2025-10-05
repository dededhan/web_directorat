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
        'catatan_admin',
        'bukti_keuangan_path',
        'nama_calon_responden', // Tambahan
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}