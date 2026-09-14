<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonRegistration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public const ROLE_LABELS = [
        'dosen' => 'Dosen',
        'tendik' => 'Tendik',
        'alumni' => 'Alumni',
        'peneliti' => 'Peneliti',
        'dudi' => 'DUDI',
        'pppk' => 'PPPK',
        'mahasiswa' => 'Mahasiswa',
    ];

    public const STATUS_LABELS = [
        'pending' => 'Menunggu',
        'approved' => 'Disetujui',
        'declined' => 'Ditolak',
    ];

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function getRoleLabelAttribute(): string
    {
        return self::ROLE_LABELS[$this->role] ?? $this->role;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
