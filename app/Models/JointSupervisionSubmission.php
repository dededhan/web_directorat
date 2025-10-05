<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class JointSupervisionSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pengunggah',
        'proposal_path',
        'status',
        'catatan_admin',
        'bukti_keuangan_path',
    ];

    /**
     * Get the user that owns the submission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}