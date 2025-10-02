<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentingSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'presenting_report_id',
        'bukti_perjalanan_path',
        'sertifikat_presenter_path',
        'ppt_path',
        'bukti_partner_riset_path',
        'sp_setneg_path',
        'responden_internasional_qs_path',
    ];

    // Satu Submission MILIK SATU Laporan
    public function report()
    {
        return $this->belongsTo(PresentingReport::class, 'presenting_report_id');
    }
}