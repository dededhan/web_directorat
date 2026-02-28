<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeTahap extends Model
{
    use HasFactory;

    protected $table = 'inov_chalenge_tahap';

    protected $guarded = ['id'];

    protected $casts = [
        'has_anggota' => 'boolean',
        'has_fakultas' => 'boolean',
        'periode_awal' => 'datetime',
        'periode_akhir' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(InovChalengeSession::class, 'inov_chalenge_session_id');
    }

    public function fields()
    {
        return $this->hasMany(InovChalengeTahapField::class, 'inov_chalenge_tahap_id')
            ->orderBy('urutan');
    }

    public function sections()
    {
        return $this->hasMany(InovChalengeTahapSection::class, 'inov_chalenge_tahap_id')
            ->orderBy('urutan');
    }

    /**
     * Fields that do NOT belong to any section (legacy / free-floating).
     */
    public function unsectionedFields()
    {
        return $this->hasMany(InovChalengeTahapField::class, 'inov_chalenge_tahap_id')
            ->whereNull('inov_chalenge_tahap_section_id')
            ->orderBy('urutan');
    }
}
