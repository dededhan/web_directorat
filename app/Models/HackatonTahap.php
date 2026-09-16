<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonTahap extends Model
{
    use HasFactory;

    protected $table = 'hackaton_tahap';

    protected $guarded = ['id'];

    protected $casts = [
        'has_anggota' => 'boolean',
        'has_fakultas' => 'boolean',
        'periode_awal' => 'datetime',
        'periode_akhir' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(HackatonSession::class, 'hackaton_session_id');
    }

    public function fields()
    {
        return $this->hasMany(HackatonTahapField::class, 'hackaton_tahap_id')
            ->orderBy('urutan');
    }

    public function sections()
    {
        return $this->hasMany(HackatonTahapSection::class, 'hackaton_tahap_id')
            ->orderBy('urutan');
    }

    public function unsectionedFields()
    {
        return $this->hasMany(HackatonTahapField::class, 'hackaton_tahap_id')
            ->whereNull('hackaton_tahap_section_id')
            ->orderBy('urutan');
    }

    public function isOpen(): bool
    {
        $now = now();
        if ($this->periode_awal && $now->lt($this->periode_awal)) return false;
        if ($this->periode_akhir && $now->gt($this->periode_akhir)) return false;
        return true;
    }

    public function isUpcoming(): bool
    {
        return $this->periode_awal && now()->lt($this->periode_awal);
    }

    public function isClosed(): bool
    {
        return $this->periode_akhir && now()->gt($this->periode_akhir);
    }

    public function getTimingStatus(): string
    {
        if ($this->isUpcoming()) return 'belum_dibuka';
        if ($this->isClosed()) return 'ditutup';
        return 'dibuka';
    }
}
