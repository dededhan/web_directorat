<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonSubmissionIdentitas extends Model
{
    use HasFactory;

    protected $table = 'hackaton_submission_identitas';

    protected $fillable = [
        'hackaton_submission_id',
        'nama_produk',
        'skema_inovasi',
        'bidang_utama_produk',
    ];

    public function submission()
    {
        return $this->belongsTo(HackatonSubmission::class, 'hackaton_submission_id');
    }
}
