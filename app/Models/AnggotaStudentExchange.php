<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaStudentExchange extends Model
{
    use HasFactory;

    protected $table = 'anggota_student_exchange';

    protected $fillable = [
        'proposal_student_exchange_id',
        'nama_dosen',
        'nip',
        'fakultas',
        'prodi',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    /**
     * Get the proposal this anggota belongs to.
     */
    public function proposal()
    {
        return $this->belongsTo(ProposalStudentExchange::class, 'proposal_student_exchange_id');
    }
}
