<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenInternasional extends Model
{
    use HasFactory;

    protected $fillable = [
        'fakultas',
        'prodi',
        'nama',
        'jenis_kelamin',
        'jabatan',
        'negara',
        'universitas_asal',
        'email',
        'subject_1',
        'subject_2',
        'status',
        'bidang_keahlian',
        'email_status',
        'email_sent_at',
        'email_error',
        'consent_status',
        'consent_token',
        'consented_at',
        'sesi',
        'tahun',
        'link_bukti_kegiatan',
    ];

    protected $casts = [
        'email_sent_at' => 'datetime',
        'consented_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (DosenInternasional $model) {
            $sanitizable = [
                'nama', 'jenis_kelamin', 'jabatan', 'universitas_asal', 'negara',
                'email', 'subject_1', 'subject_2', 'fakultas', 'prodi',
                'status', 'bidang_keahlian', 'sesi', 'tahun', 'link_bukti_kegiatan'
            ];

            foreach ($sanitizable as $field) {
                if (array_key_exists($field, $model->attributes)) {
                    if ($field === 'email') {
                        $model->attributes[$field] = \App\Services\LecturerDataSanitizer::cleanEmail($model->attributes[$field]);
                    } elseif ($field === 'negara') {
                        $model->attributes[$field] = \App\Services\LecturerDataSanitizer::normalizeCountry($model->attributes[$field]);
                    } elseif ($field === 'subject_1') {
                        $fac = $model->attributes['fakultas'] ?? $model->fakultas ?? null;
                        $prodi = $model->attributes['prodi'] ?? $model->prodi ?? null;
                        $model->attributes[$field] = \App\Services\LecturerDataSanitizer::normalizeSubject($model->attributes[$field], $fac, $prodi);
                    } elseif ($field === 'subject_2') {
                        $model->attributes[$field] = null;
                    } else {
                        $model->attributes[$field] = \App\Services\LecturerDataSanitizer::cleanValue($model->attributes[$field]);
                    }
                }
            }
        });
    }

    public function isEmailDeliverable(?string &$reason = null): bool
    {
        return \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($this->email, $reason);
    }

    public function activities()
    {
        return $this->hasMany(AktivitasDosenAsing::class, 'dosen_internasional_id');
    }
}
