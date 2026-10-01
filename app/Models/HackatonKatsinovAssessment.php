<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonKatsinovAssessment extends Model
{
    use HasFactory;

    protected $table = 'hackaton_katsinov_assessments';

    protected $fillable = [
        'hackaton_submission_id',
        'user_id',
        'judul_inovasi',
        'fokus_bidang',
        'nama_tim',
        'institusi',
        'alamat',
        'kontak',
        'assessment_date',
        'achieved_level',
        'overall_percentage',
        'aspect_scores',
        'indicator_scores',
        'responses',
        'notes',
        'signature_image',
        'signed_at',
        'share_token',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'signed_at' => 'datetime',
        'achieved_level' => 'integer',
        'overall_percentage' => 'float',
        'aspect_scores' => 'array',
        'indicator_scores' => 'array',
        'responses' => 'array',
        'notes' => 'array',
    ];

    public function submission()
    {
        return $this->belongsTo(HackatonSubmission::class, 'hackaton_submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function aspectLabels(): array
    {
        return [
            'T' => 'Teknologi (T)',
            'O' => 'Organisasi (O)',
            'R' => 'Risiko (R)',
            'M' => 'Pasar (M)',
            'P' => 'Kemitraan (P)',
            'Mf' => 'Manufaktur (Mf)',
            'I' => 'Investasi (I)',
        ];
    }
}
