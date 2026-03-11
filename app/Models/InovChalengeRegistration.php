<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeRegistration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    /**
     * Role labels for display.
     */
    public const ROLE_LABELS = [
        'dosen'    => 'Dosen',
        'tendik'   => 'Tendik',
        'alumni'   => 'Alumni',
        'peneliti' => 'Peneliti',
        'dudi'     => 'DUDI',
        'pppk'     => 'PPPK',
        'mahasiswa' => 'Mahasiswa',
    ];

    /**
     * Status labels for display.
     */
    public const STATUS_LABELS = [
        'pending'  => 'Menunggu',
        'approved' => 'Disetujui',
        'declined' => 'Ditolak',
    ];

    /**
     * Admin who processed this registration.
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get role label.
     */
    public function getRoleLabelAttribute(): string
    {
        return self::ROLE_LABELS[$this->role] ?? $this->role;
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
