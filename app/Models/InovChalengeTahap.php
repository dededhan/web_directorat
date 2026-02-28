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

    // ── Timing helpers ──────────────────────────────────────────

    /**
     * Check if this tahap period has started and not yet ended.
     */
    public function isOpen(): bool
    {
        $now = now();
        if ($this->periode_awal && $now->lt($this->periode_awal)) return false;
        if ($this->periode_akhir && $now->gt($this->periode_akhir)) return false;
        return true;
    }

    /**
     * Check if this tahap period hasn't started yet.
     */
    public function isUpcoming(): bool
    {
        return $this->periode_awal && now()->lt($this->periode_awal);
    }

    /**
     * Check if this tahap period has passed.
     */
    public function isClosed(): bool
    {
        return $this->periode_akhir && now()->gt($this->periode_akhir);
    }

    /**
     * Get human-readable timing status.
     */
    public function getTimingStatus(): string
    {
        if ($this->isUpcoming()) return 'belum_dibuka';
        if ($this->isClosed()) return 'ditutup';
        return 'dibuka';
    }
}
