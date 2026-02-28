<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeSubmissionIdentitas extends Model
{
    use HasFactory;

    protected $table = 'inov_chalenge_submission_identitas';

    protected $fillable = [
        'inov_chalenge_submission_id',
        'nama_produk',
        'skema_inovasi',
        'bidang_utama_produk',
    ];

    public function submission()
    {
        return $this->belongsTo(InovChalengeSubmission::class, 'inov_chalenge_submission_id');
    }
}
