<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExchangeMitra extends Model
{
    use HasFactory;

    protected $table = 'student_exchange_mitra';

    protected $fillable = [
        'proposal_student_exchange_id',
        'nama_mitra',
        'negara',
        'nama_pic',
        'nomor_kontak_pic',
        'email_pic',
        'kesediaan_mitra_path',
    ];

    /**
     * Get the proposal this mitra belongs to.
     */
    public function proposal()
    {
        return $this->belongsTo(ProposalStudentExchange::class, 'proposal_student_exchange_id');
    }
}
